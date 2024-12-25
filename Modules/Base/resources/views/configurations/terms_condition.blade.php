@extends('layouts.admin_app')
@section('title')
Terms & Condition Settings
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Terms & Condition Settings</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('base_settings_update.configurations')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">  
                                <x-common.text-editor label="Purchase Terms and Condition" :required="false" column=6 name="purchase_terms_condition" id="purchase_terms_condition" :value="app('general_setting')['purchase_terms_condition']"></x-common.text-editor>
                                <x-common.text-editor label="Sales Terms and Condition" :required="false" column=6 name="sale_terms_condition" id="sale_terms_condition" :value="app('general_setting')['sale_terms_condition']"></x-common.text-editor>
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