@extends('layouts.admin_app')
@section('title')
Company Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Company Settings</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('base_settings_update.configurations')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">                                
                                <x-common.input :required="true" column=6 id="company_name" name="company_name" label="Company Name" placeholder="Company Name" :value="app('general_setting')['company_name']"></x-common.input>
                                <x-common.input :required="true" column=6 id="company_phone" name="company_phone" label="Company Phone" placeholder="Company Phone" :value="app('general_setting')['company_phone']"></x-common.input>
                                <x-common.input :required="true" column=6 id="company_email" name="company_email" type="email" label="Company Email" placeholder="Company Email" :value="app('general_setting')['company_email']"></x-common.input>
                                <x-common.text-area :required="true" column=12 name="company_address" label="Company Address" placeholder="Company Address" :value="app('general_setting')['company_address']"></x-common.text-area>
                                <x-common.file-browse label="Company Logo" :required="false" column=6 name="company_logo" extension="application/image"></x-common.file-browse>
                                <x-common.file-browse label="Favicon" :required="false" column=6 name="favicon" extension="application/image"></x-common.file-browse>
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection