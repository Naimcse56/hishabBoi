<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Hash;
use Modules\Base\App\Models\GeneralSetting;
use App\Models\User;
// use MehediIitdu\CoreComponentRepository\CoreComponentRepository;
use Artisan;
use Session;

class InstallController extends Controller
{
    public function step0() {
        // $this->writeEnvironmentFile('APP_URL', URL::to('/'));
        return view('installation.step0');
    }

    public function step1() {
        $permission['curl_enabled']           = function_exists('curl_version');
        $permission['db_file_write_perm']     = is_writable(base_path('.env'));
        $permission['routes_file_write_perm'] = is_writable(base_path('bootstrap\app.php'));
        return view('installation.step1', compact('permission'));
    }

    public function step2() {
        return view('installation.step2');
    }

    public function step3($error = "") {
        // CoreComponentRepository::instantiateShopRepository();
        // if($error == ""){
            return view('installation.step3');
        // }else {
        //     return view('installation.step3', compact('error'));
        // }
    }

    public function step4() {
        return view('installation.step4');
    }

    public function step5() {
        return view('installation.step5');
    }

    public function purchase_code(Request $request) {
        // if (\App\Utility\CategoryUtility::create_initial_category($request->purchase_code) == false) {
        //     flash("Sorry! The purchase code you have provided is not valid.")->error();
        //     return back();
        // }
        Session::put('purchase_code', $request->purchase_code);
        return redirect('step3');
    }

    public function system_settings(Request $request) {

        $currency_id = explode('-',$request->system_default_currency)[0];
        $currency_symbol = explode('-',$request->system_default_currency)[1];
        GeneralSetting::where('name','system_currency_id')->first()->update(['value' => $currency_id]);
        GeneralSetting::where('name','system_currency_symbol')->first()->update(['value' => $currency_symbol]);

        $this->writeEnvironmentFile('APP_NAME', $request->system_name);
        Artisan::call('key:generate');

        $user = new User;
        $user->name      = $request->admin_name;
        $user->username  = str_replace(' ','-',strtolower($request->admin_name));
        $user->email     = $request->admin_email;
        $user->password  = Hash::make($request->admin_password);
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();

        //Assign Super-Admin Role
        // $user->assignRole(['Super Admin']);

        $previousRouteServiceProvier = base_path('bootstrap\app.php');
        $newRouteServiceProvier      = base_path('bootstrap\app.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        //sleep(5);

        if (Session::has('purchase_code')) {
            $business_settings = new GeneralSetting;
            $business_settings->name = 'purchase_code';
            $business_settings->value = Session::get('purchase_code');
            $business_settings->save();
            Session::forget('purchase_code');
        }
        return view('installation.step6');
    }
    public function database_installation(Request $request) {
        if(self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {
            $path = base_path('.env');
            if (file_exists($path)) {
                foreach ($request->types as $type) {
                    $this->writeEnvironmentFile($type, $request[$type]);
                }
                try {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed');
                } catch (\Throwable $th) {
                    dd($th);
                }
                return redirect('step4');
            }else {
                return redirect('step3');
            }
        }else {dd("s");
            return redirect('step3/database_error');
        }
    }

    public function import_sql() {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed');
        return redirect('step5');
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "") {

        if(@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        }else {
            return false;
        }
    }

    public function writeEnvironmentFile($type, $val) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            file_put_contents($path, str_replace(
                $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
            ));
        }
    }
}
