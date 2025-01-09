<?php

namespace Modules\Base\App\Http\Controllers;

use Mail;
use App\Models\User;
use App\Mail\EmailManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Modules\Base\App\Models\GeneralSetting;
use Modules\Accounts\App\Models\AccountConfiguration;
 
class BaseController extends Controller
{

     public function user_permisssions(Request $request)
    {
        $data['user_id'] = $request->query('user_id');
        $data['permissions'] = Permission::all();
    
        $data['user'] = User::find($data['user_id']);
        $data['assigned_permissions'] = $data['user'] ? $data['user']->getPermissionNames()->toArray() : [];
     
        return view('base::configurations.user_permissions', $data);
    }
     public function store_permisssions(Request $request)
    {
         $validated = $request->validate([
        'user_id' => 'required|exists:users,id',  
        'permissions' => 'required|array',  
        'permissions.*' => 'exists:permissions,name', 
    ]);
      // Find the user
    $user = User::findOrFail($validated['user_id']);

    // Assign the permissions to the user
    $user->syncPermissions($validated['permissions']);
 return back()->with('success', 'Parmission Assigned Successfully.');
   
    }


    /**
     * Display a listing of the resource.
     */
    public function company_settings()
    {
        return view('base::configurations.company_settings');
    }
    
    public function general_settings()
    {
        return view('base::configurations.general_settings');
    }
    
    public function email_settings()
    {
        return view('base::configurations.email_settings');
    }
    
    public function sales_purchase()
    {        
        $data['settings'] = GeneralSetting::get();
        return view('base::configurations.sales_purchase_config', $data);
    }

    public function base_settings_update(Request $request)
    {
        foreach ($request->except('_token','system_currency_id') as $column_name => $column_value) {
            GeneralSetting::where('name',$column_name)->first()->update(['value' => $column_value]);
        }
        if ($request->system_currency_id) {
            $currency_id = explode('-',$request->system_currency_id)[0];
            $currency_symbol = explode('-',$request->system_currency_id)[1];
            GeneralSetting::where('name','system_currency_id')->first()->update(['value' => $currency_id]);
            GeneralSetting::where('name','system_currency_symbol')->first()->update(['value' => $currency_symbol]);
        }

        return back()->with('success', 'Updated Successfully');
    }

    public function env_settings_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        return back()->with('success', 'Updated Successfully');
    }

    public function overWriteEnvFile($type, $val)
    {
        if(env('DEMO_MODE') != 'On'){
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }

    public function test_mail_send(Request $request){
        $array['view'] = 'base::email_templates.test_mail';
        $array['subject'] = "Test Mail";
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = $request->message;

        try {
            Mail::to($request->email)->queue(new EmailManager($array));
            return back()->with('success', 'Mail Sent Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
