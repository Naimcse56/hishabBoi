@extends('layouts.admin_app')
@section('title')
General Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">General Setting</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('work-order.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                
                                <x-common.input :required="true" column=6 id="company_name" name="company_name" label="Company Name" placeholder="Company Name" :value="old('company_name')"></x-common.input>
                                <x-common.input :required="true" column=6 id="site_title" name="site_title" label="Site Title" placeholder="Site Title" :value="old('site_title')"></x-common.input>
                                <x-common.input :required="true" column=6 id="phone" name="phone" type="number" label="Phone" placeholder="Phone" :value="old('phone')"></x-common.input>
                                <x-common.input :required="true" column=6 id="email" name="email" label="Email" placeholder="Email" :value="old('email')"></x-common.input>
                               
                                 <x-common.text-area :required="true" column=12 name="address" label="Address" placeholder="Address"></x-common.text-area>
                            </div>
                               <x-common.file-browse label="Logo" :required="false" column=12 name="logo" extension="application/image"></x-common.file-browse>
                         
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
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN; 
            $(document).ready(function(){
                getMainAccountCreate();
                getCostAccount();
            });

            function getMainAccountCreate(){
                $(".sub_ledger_id").select2({
                    ajax: {
                        url: "{{route('sub-ledger.transactional_list_for_select')}}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: 'Client'
                                }
                                return query;
                        },
                        cache: false
                    },
                });
            }

            function getCostAccount(){
                $(".cost_account_id").select2({
                    ajax: {
                        url: '{{route('ledger.transactional_list_for_select')}}',
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: "expense",
                                    account_type: 3,
                                }
                                return query;
                        },
                        cache: false
                    },
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            }

            $(document).on('click', '#add_new_line', function(e){
                e.preventDefault();
                $.ajax({
                    url: '{{route('work-order.get_row')}}',
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        $(".entry_row_div").append(response);
                        getCostAccount();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.delete_new_row', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row").remove();
                getSumAmount();
            });
        })(jQuery);
    </script>
@endpush