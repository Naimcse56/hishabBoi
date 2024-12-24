<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mail;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function company_settings()
    {
        return view('base::configurations.company_settings');
    }
    
    public function email_settings()
    {
        return view('base::configurations.email_settings');
    }

    public function company_settings_update(Request $request)
    {
        dd($request->all());
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
            return back()->with('success', 'Sent Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
