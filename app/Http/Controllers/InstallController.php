<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Hash;
// use MehediIitdu\CoreComponentRepository\CoreComponentRepository;
use Artisan;
use Session;

class InstallController extends Controller
{
    public function database_installation(Request $request) {
        try {
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed');
            $path = base_path('.env');
            if (file_exists($path)) {
                $type = "SCRIPT_INSTALLED";
                $val = '"YES"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
            return response()->json(['message' => "Successfully Completed. Your Login Email is: 'admin@example.com' and Password : 'admin@example.com'. Please after first login change your password!!"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
