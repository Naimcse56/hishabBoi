@extends('layouts.admin_app')
@section('title')
Chart of Accounts
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Edit Ledger Account</h4></div>
        <div><a href="{{route('ledger.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('ledger.update', encrypt($ledger->id))}}">
                        @csrf
                        <div class="row">
                            <x-common.server-side-select :required="true" column=4 name="parent_id" id="parent_id" class="parent_id" disableOptionText="Select Parent" label="Parent Account" :options="[
                                ['id' => $ledger->parent_id, 'name' => $ledger->parent->name]
                            ]" :value="$ledger->parent_id"></x-common.server-side-select>
                            <x-common.input :required="true" column=4 id="name" name="name" label="Account Head" placeholder="Account Head" :value="old('name',$ledger->name)"></x-common.input>
                            <x-common.input :required="true" column=4 id="code" name="code" label="Account Code" placeholder="Account Code" :value="old('code',$ledger->code)"></x-common.input>
                            <x-common.radio :required="true" column=4 name="acc_type" class="acc_type" label="Ledger Type" placeholder="Ledger Type" :value="$ledger->acc_type" :options="[
                                ['id' => 'cash', 'name' => 'Cash'],
                                ['id' => 'bank', 'name' => 'Bank'],
                                ['id' => 'others', 'name' => 'Others']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="$ledger->is_active" :options="[
                                ['id' => 1, 'name' => 'Active'],
                                ['id' => 0, 'name' => 'Inactive']
                            ]"></x-common.radio>
                        </div>
                            
                        <div class="row ac_no_div {{$ledger->acc_type == "bank" ? '' : 'd-none'}}">
                            <div class="col-md-12 general_config_div">
                                <fieldset class="the-fieldset mt-2">
                                    <legend class="the-legend">Bank Information</legend>
                                    <div class="row">
                                        <x-common.input :required="true" column=4 id="bank_ac_name" name="bank_ac_name" label="Bank Account Name" placeholder="Bank Account Name" :value="old('bank_ac_name', $ledger->bank_ac_name)"></x-common.input>
                                        <x-common.input :required="true" column=4 id="ac_no" name="ac_no" label="Bank Account No" placeholder="Bank Account No" :value="old('ac_no', $ledger->ac_no)"></x-common.input>
                                        <x-common.input :required="true" column=4 id="routing_no" name="routing_no" label="Routing No" placeholder="Routing No" :value="old('routing_no', $ledger->routing_no)"></x-common.input>
                                        <x-common.input :required="true" column=4 id="swift_code" name="swift_code" label="Swift Code" placeholder="Swift Code" :value="old('swift_code', $ledger->swift_code)"></x-common.input>
                                        <x-common.input :required="true" column=4 id="branch_code" name="branch_code" label="Branch Code" placeholder="Branch Code" :value="old('branch_code', $ledger->branch_code)"></x-common.input>
                                        <x-common.input :required="true" column=4 id="bank_address" name="bank_address" label="Bank Address" placeholder="Bank Address" :value="old('bank_address', $ledger->bank_address)"></x-common.input>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <input type="hidden" name="s_id" id="s_id" value="{{$ledger->id}}">
                        <input type="hidden" name="row_count" id="row_count" value="1">
                        <input type="hidden" name="class_name" id="class_name" value="0">
                        <div class="row">
                            <x-common.button column=12 type="submit" id="update_btn" class="btn-primary btn-120" :value="' Update'" :icon="'fa fa-check'"></x-common.button>
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
                        s_id: $('#s_id').val(),
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
                    codeCheck($(this).val());
                }
            });
            function codeCheck(params) {
                let code = params;
                $.ajax({
                    method: "POST",
                    url: "{{ route('ledger.code_checker') }}",
                    data: {
                        code: code,
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        console.log(typeof result.message === "undefined");
                        if (typeof result.message !== "undefined") {
                            $("#code_error").removeClass('text-success').addClass('text-danger').text(result.message);
                        }else{
                            $("#code_error").removeClass('text-danger').addClass('text-success').text("");
                        }
                    }
                });
            }

            $(document).on('click', '.acc_type', function(e){
                if ($(this).val() == "bank") {
                    $('.ac_no_div').removeClass('d-none')
                } else {
                    $('.ac_no_div').addClass('d-none')
                }
            });

        })(jQuery);
    </script>
@endpush