@extends('layouts.admin_app')
@section('title')
Chart of Accounts
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">New Ledger Account</h4></div>
        <div><a href="{{route('ledger.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New Ledger</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="journal_create_form" method="POST" enctype="multipart/form-data" action="{{route('ledger.store')}}">
                        @csrf
                        <div class="row">
                            <x-common.server-side-select :required="true" column=4 name="parent_id" id="parent_id" class="parent_id" disableOptionText="Select Parent" label="Parent Account"></x-common.server-side-select>
                            <x-common.input :required="true" column=4 id="name" name="name" label="Account Head" placeholder="Account Head" :value="old('name')"></x-common.input>
                            <x-common.input :required="true" column=4 id="code" name="code" label="Account Code" placeholder="Account Code" :value="old('code')"></x-common.input>
                            <x-common.radio :required="true" column=4 id="acc_type" name="acc_type" class="acc_type" label="Ledger Type" placeholder="Ledger Type" :value="'others'" :options="[
                                ['id' => 'cash', 'name' => 'Cash'],
                                ['id' => 'bank', 'name' => 'Bank'],
                                ['id' => 'others', 'name' => 'Others']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 id="is_active" name="is_active" class="is_active" label="Status" placeholder="Status" :value="1" :options="[
                                ['id' => 1, 'name' => 'Active'],
                                ['id' => 0, 'name' => 'Inactive']
                            ]"></x-common.radio>
                        </div>
                            
                        <div class="row ac_no_div d-none">
                            <div class="col-md-12 general_config_div">
                                <fieldset class="the-fieldset mt-2">
                                    <legend class="the-legend">Bank Information</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="bank_ac_name">Bank Account Name</label>
                                            <input id="bank_ac_name" name="bank_ac_name" class="form-control" placeholder="Account Name" type="text">
                                            <span class="text-danger" id="bank_ac_name_error"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="ac_no">Bank Account No</label>
                                            <input id="ac_no" name="ac_no" class="form-control" placeholder="Account Code" type="text">
                                            <span class="text-danger" id="ac_no_error"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="routing_no">Routing No</label>
                                            <input id="routing_no" name="routing_no" class="form-control" placeholder="Routing No" type="text">
                                            <span class="text-danger" id="routing_no_error"></span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label mt-2" for="swift_code">Swift Code</label>
                                            <input id="swift_code" name="swift_code" class="form-control" placeholder="Swift Code" type="text">
                                            <span class="text-danger" id="swift_code_error"></span>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="branch_code">Branch Code</label>
                                            <input id="branch_code" name="branch_code" class="form-control" placeholder="Branch Code" type="text">
                                            <span class="text-danger" id="branch_code_error"></span>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="bank_address">Bank Address</label>
                                            <input id="bank_address" name="bank_address" class="form-control" placeholder="Bank Address" type="text">
                                            <span class="text-danger" id="bank_address_error"></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-12 general_config_div">
                                <fieldset class="the-fieldset mt-5">
                                    <legend class="the-legend">Balance Sheet & Income Statement Configuration</legend>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label" for="">Display in Balance Sheet <span class="text-danger">*</span></label>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_bs" value="1">
                                                    <label class="form-check-label" for="view_in_bs">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_bs" value="0" checked>
                                                    <label class="form-check-label" for="view_in_bs">No</label>
                                                </div>
                                            </div>
                                            <span class="text-danger" id="is_active_error">{{$errors->first('view_in_bs')}}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="">Display in Income Statement <span class="text-danger">*</span></label>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_is" value="1">
                                                    <label class="form-check-label" for="view_in_is">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_is" value="0" checked>
                                                    <label class="form-check-label" for="view_in_is">No</label>
                                                </div>
                                            </div>
                                            <span class="text-danger" id="is_active_error">{{$errors->first('view_in_is')}}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="">Display in Trial Balance <span class="text-danger">*</span></label>
                                            <div class="">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_trial" value="1">
                                                    <label class="form-check-label" for="view_in_trial">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="view_in_trial" value="0" checked>
                                                    <label class="form-check-label" for="view_in_trial">No</label>
                                                </div>
                                            </div>
                                            <span class="text-danger" id="is_active_error">{{$errors->first('view_in_trial')}}</span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary save-btn "><i class="bx bx-check-double"></i>Save</button>
                            </div>
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(".as_sub_category").unbind().click(function () {
                    $(".parent_chartAccount").toggle();
                    $("#account_type").toggle();
                });
            });

            $(document).on('change', '#parent_id', function(e) {
                generateCode($('#parent_id').val());
            });
            
            $(".parent_id").select2({
                ajax: {
                    url: '{{route('ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                branch_id: $(".branch_id").val(),
                                view: 'ledger'
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function generateCode(parent_id) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('ledger.code_checker') }}",
                    data: {
                        parent_id: parent_id,
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        if (typeof result.generated_code !== "undefined") {
                            $("#code").val(result.generated_code);
                        }else{
                            alert('Oops! Reload your browser please!')
                        }
                    }
                });
            }

            $(document).on('keyup', '#name', function(e) {
                if ($(this).val().length >= 3 && (e.keyCode != 40 || e.keyCode === 38)) {
                    var name = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "{{ route('ledger.code_checker') }}",
                        data: {
                            code: name,
                            purpose: "name",
                            _token: APP_TOKEN,
                        },
                        success: function(result) {
                            if (typeof result.message !== "undefined") {
                                $("#name_error").removeClass('text-success').addClass('text-danger mt-4').text(result.message);
                            }else{
                                $("#name_error").removeClass('text-danger').addClass('text-success').text("");
                            }
                        }
                    });
                }
            });

            $(document).on('keyup', '#code', function(e) {
                if ($(this).val().length >= 2 && (e.keyCode != 40 || e.keyCode === 38)) {
                    codeCheck($(this).val(), $('#type').val());
                }
            });
            function codeCheck(params, type) {
                let code = params;
                $.ajax({
                    method: "POST",
                    url: "{{ route('ledger.code_checker') }}",
                    data: {
                        code: code,
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        if (typeof result.message !== "undefined") {
                            $("#code_error").removeClass('text-success').addClass('text-danger').text(result.message);
                        }else{
                            $("#code_error").removeClass('text-danger').addClass('text-success').text("");
                        }
                    }
                });
            }

            $(document).on('change', '.acc_type', function(e){
                console.log($(this));
                
                if ($(this).val() == "bank") {
                    $('.ac_no_div').removeClass('d-none')
                } else {
                    $('.ac_no_div').addClass('d-none')
                }
            });

        })(jQuery);
    </script>
@endpush