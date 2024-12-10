@extends('layouts.admin_app')
@section('title')
Opening Balance Entry
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">New Entry Opening Balance</h4></div>
            <div><a href="{{route('opening-balance.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="journal_create_form" method="POST" enctype="multipart/form-data">
                            <div class="row mb-2">
                                <x-common.date-picker label="Date" :required="true" column=4 name="date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.input :required="false" column=4 id="concern_person" name="concern_person" label="Concern Person" placeholder="Concern Person" :value="old('concern_person')"></x-common.input>
                                <x-common.text-area :required="false" column=12 name="narration" label="Purpose / Narration" placeholder="Remarks..."></x-common.text-area>
                            </div>
                            <fieldset class="the-fieldset">
                                <legend class="the-legend">Journal Details Information</legend>
                                <div class="entry_row_div">
                                    <div class="row new_added_row">  
                                        <x-common.server-side-select :required="true" column=4 name="account_id[]" class="account_id" disableOptionText="Select Ledger Account" label="Ledger Accounts"></x-common.server-side-select>
                                        <x-common.server-side-select :required="false" column=3 name="sub_account_id[]" class="sub_account_id" disableOptionText="Select Party Account" label="Party Accounts (Dr)"></x-common.server-side-select>
                                        <x-common.input :required="true" column=2 name="debit_amount[]" class="debit_amount" type="number" step="0.01" label="Debit Amount" placeholder="Amount" :value="'0'"></x-common.input>                              
                                        <x-common.input :required="true" column=2 name="credit_amount[]" class="credit_amount" type="number" step="0.01" label="Credit Amount" placeholder="Amount" :value="'0'"></x-common.input>                              
                                         
                                        <div class="col-md-1 mb-3">
                                            <div class="d-block">
                                                <label class="form-label" for=""> Action </label>
                                                <div>
                                                    <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="col-md-7 text-right">
                                    <label class="form-label" for="Total Amount">Total Amount (BDT) :</label>
                                </div>
                                <div class="col-md-2 text-right">
                                    <label class="form-label total_debit_amount" for="Dr Amount">0.00</label>
                                </div>
                                <div class="col-md-2 text-right">
                                    <label class="form-label total_credit_amount" for="Cr Amount">0.00</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-primary" id="add_new_line">Add New Row</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary save-btn "><i class="bx bx-check-double"></i>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="ajaxDiv"></div>
        <input type="hidden" value="{{route('ledger.transactional_list_for_select')}}" id="ledger_list_select_option">
        <input type="hidden" value="{{ route("journal.add_new_line") }}" id="add_new_entry">
        <input type="hidden" value="{{route('opening-balance.store')}}" id="journal_store_url">
        <input type="hidden" id="v_id" name="v_id" value="{{session()->get('voucher_id') ? session()->get('voucher_id') : 0}}">
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN; 
            var row = (parseInt($('.new_added_row').length) > 0) ? parseInt($('.new_added_row').length) : 1;
            var inputTimeout;

            $(document).ready(function(){
                getPrint();
                getMainAccount();
                getPartners();
            });

            $(document).on('focus', '.debit_amount,.credit_amount', function(e){
                e.preventDefault();
                $(this).val("");
            });

            $(document).on('focusout', '.debit_amount,.credit_amount', function(e){
                e.preventDefault();
                if (!$.isNumeric($(this).val())) {
                    $(this).val(0);
                }
            });
            function getPrint(){
                let v_id = $('#v_id').val();
                if (v_id != 0) {
                    window.open(v_id, 'window name', 'window settings')
                }
            }

            $(document).on('click', '#add_new_line', function(e){
                e.preventDefault();
                row += 1;
                $.ajax({
                    url: $('#add_new_entry').val(),
                    type: "GET",
                    dataType: "JSON",
                    data: {row:row},
                    success: function (response) {
                        $(".entry_row_div").append(response);
                        getMainAccount();
                        getPartners();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.delete_new_row', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row").remove();
            });

            $(document).on('submit', '.journal_create_form', function(event){
                event.preventDefault();
                go_for_form_submit();
            });
    
            $(document).on('keyup', '.debit_amount, .credit_amount', function(){
                if (inputTimeout) {
                    clearTimeout(inputTimeout);
                }
                inputTimeout = setTimeout(getSumAmount, 500);
            });

            function go_for_form_submit(){
                let formElement = $('.journal_create_form').serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',APP_TOKEN);
                $.ajax({
                    url: $('#journal_store_url').val(),
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        if(response.message_warning !== undefined)
                        {
                            alert(response.message_warning);
                        }else if (response.message !== undefined) {
                            $(".entry_row_div").html("");
                            $(".narration").val("");
                            alert(response.message);
                            window.location.replace(response.url);
                        }else {
                            alert("Something went wrong");
                        }
                    },
                    error:function(response) {
                        if (response.message_error !== undefined) {
                            alert(response.message_error)
                        }else {
                            alert(response.responseJSON.message);
                        }
                    }
                });
            }

            function sumAmount()
            {
                var debit_amounts = $("input[name='debit_amount[]']").map(function(){return $(this).val();}).get();
                var credit_amounts = $("input[name='credit_amount[]']").map(function(){return $(this).val();}).get();
                var debit_amounts_sum = 0;
                var credit_amounts_sum = 0;
                for (var i = 0; i < debit_amounts.length; i++) {
                    debit_amounts_sum = parseFloat(debit_amounts_sum) + parseFloat(debit_amounts[i]);
                }
                for (var i = 0; i < credit_amounts.length; i++) {
                    credit_amounts_sum = parseFloat(credit_amounts_sum) + parseFloat(credit_amounts[i]);
                }
                if (parseFloat(credit_amounts_sum) > parseFloat(debit_amounts_sum)) {
                    var last_div = $('.entry_row_div .new_added_row:last-child');
                    last_div.find(".debit_amount").val(parseFloat(credit_amounts_sum) - parseFloat(debit_amounts_sum));
                }
                if (parseFloat(debit_amounts_sum) > parseFloat(credit_amounts_sum)) {
                    var last_div = $('.entry_row_div .new_added_row:last-child');
                    last_div.find(".credit_amount").val(parseFloat(debit_amounts_sum) - parseFloat(credit_amounts_sum));
                }

                getSumAmount();
            }

            function getSumAmount()
            {
                var debit_amounts = $("input[name='debit_amount[]']").map(function(){return $(this).val();}).get();
                var credit_amounts = $("input[name='credit_amount[]']").map(function(){return $(this).val();}).get();
                var debit_amounts_sum = 0;
                var credit_amounts_sum = 0;
                for (var i = 0; i < debit_amounts.length; i++) {
                    if (debit_amounts[i] != '') {
                        debit_amounts_sum = parseFloat(debit_amounts_sum) + parseFloat(debit_amounts[i]);
                    }
                }
                for (var i = 0; i < credit_amounts.length; i++) {
                    if (credit_amounts[i] != '') {
                        credit_amounts_sum = parseFloat(credit_amounts_sum) + parseFloat(credit_amounts[i]);
                    }
                }
                $('.total_debit_amount').text(parseFloat(debit_amounts_sum.toFixed(2)));
                $('.total_credit_amount').text(parseFloat(credit_amounts_sum.toFixed(2)));
            }

            function getMainAccount(){
                $(".account_id").select2({
                    ajax: {
                        url: $('#ledger_list_select_option').val(),
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: "transactional",
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

            function getPartners(){
                $(".sub_account_id").select2({
                    ajax: {
                        url: "{{route('sub-ledger.transactional_list_for_select')}}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
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
        })(jQuery);
    </script>
@endpush
@php
    if (session()->get('voucher_id')) {
        session()->forget('voucher_id');
    }
@endphp