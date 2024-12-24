<?php

namespace Modules\Base\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function company_settings()
    {
        return view('base::configurations.company_settings');
    }

    public function company_settings_update(Request $request)
    {
        dd($request->all());
    }
}
