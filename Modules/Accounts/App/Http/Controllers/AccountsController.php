<?php

namespace Modules\Accounts\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Accounts\App\Models\AccountConfiguration;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function report_config()
    {
        $data['settings'] = AccountConfiguration::get();
        return view('accounts::configs.report_config', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function general_config_store(Request $request): RedirectResponse
    {
        try {
            foreach ($request->field_name as $key => $field_name) {
                AccountConfiguration::where('name', $field_name)->first()->update(['value'=> $request->get($field_name)]);
            }
            return redirect()->back()->with('success','Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
