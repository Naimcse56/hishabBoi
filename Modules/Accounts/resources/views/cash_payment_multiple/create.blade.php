@extends('layouts.admin_app')
@section('title')
Cash Voucher
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">New Entry Cash Voucher</h4></div>
            <div><a href="{{route('multi-cash-payment.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="journal_create_form" method="POST" enctype="multipart/form-data" action="{{route('multi-cash-payment.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="date" id="date" value="{{date('d/m/Y', strtotime(app('day_closing_info')->from_date))}}" readonly>
                                    <span class="text-danger">{{$errors->first('date')}}</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="Concern Person" class="form-label">Concern Person</label>
                                    <input type="text" class="form-control" name="concern_person" placeholder="Concern Person">
                                    <span class="text-danger">{{$errors->first('concern_person')}}</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="">Type <span class="text-danger">*</span></label>
                                    <select class="form-select main_select_2 pay_or_rcv_type" name="pay_or_rcv_type" id="pay_or_rcv_type" required>
                                        <option value="Cash" selected>Cash</option>
                                    </select>
                                    <span class="text-danger" id="pay_or_rcv_type_error"></span>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="Narration" class="form-label">Narration</label>
                                    <textarea class="form-control" name="narration" placeholder="Narration ..." rows="2"></textarea>
                                    <span class="text-danger"></span>
                                </div> 
                            </div>
                                
                            <fieldset class="the-fieldset mb-4">
                                <legend class="the-legend fw-bold bg-danger-subtle">Payment Information</legend>
                                <div class="entry_row_div_cr">
                                    <div class="row new_added_row_cr">                                    
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="">Credit Accounts <span class="text-danger">*</span></label>
                                                    <select class="form-select credit_account_id" name="credit_account_id[]" required>
                                                        <option value="0">Select One</option>
                                                    </select>
                                                    <span class="text-danger" id="_error"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Party Accounts (Cr)</label>
                                                    <select class="form-select credit_sub_account_id" name="credit_sub_account_id[]" required>
                                                        <option value="0">Select One</option>
                                                    </select>
                                                    <span class="text-danger" id="credit_sub_account_id_error"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="Narration" class="form-label">Amount <span class="text-danger">*</span></label>
                                                    <input type="number" min="0" step="0.0000001" class="form-control credit_amount" name="credit_amount[]" placeholder="0" value="0" required>
                                                    <span class="text-danger"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="Credit Account">Debit Account <span class="text-danger">*</span></label>
                                                    <select class="form-select debit_account_id" name="debit_account_id[]" required>
                                                        <option value="0" selected>Select Debit Account</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label" for="">Party Account (Dr)</label>
                                                    <select class="form-select credit_sub_account_id" name="debit_sub_account_id[]" required>
                                                        <option value="0">Select One</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3 work_order_div">
                                                    <label class="form-label">Work Order <span class="text-danger">*</span></label>
                                                    <select class="form-select work_order_id" name="work_order_id[]" required>
                                                        <option value="0">Select One</option>
                                                    </select>
                                                    <span class="text-danger" id="work_order_id_error"></span>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Work Order Site <span class="text-danger">(optional)</span></label>
                                                    <select class="form-select work_order_site_detail_id" name="work_order_site_detail_id[]">
                                                        <option value="0">Select One</option>
                                                    </select>
                                                    <span class="text-danger" id="work_order_site_detail_id_error"></span>
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <div class="d-block">
                                                        <label class="form-label" for=""> Action </label>
                                                        <div>
                                                            <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row_cr"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="Narration" class="form-label">Narration</label>
                                                    <textarea class="form-control" name="credit_narration[]" placeholder="Narration ..." rows="8"></textarea>
                                                    <span class="text-danger"></span>
                                                </div>
                                            </div>
                                        </div><hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="Total Amount">Total Amount (BDT) :</label>
                                        <label class="form-label total_credit_amount text-danger" for="Cr Amount">0.00</label>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-primary" id="add_new_line_cr">Add New Row (CR)</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-primary save-btn "><i class="bx bx-check-double"></i>Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="v_id" name="v_id" value="{{session()->get('voucher_id') ? session()->get('voucher_id') : 0}}">
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN; 

            $(document).on('click', '#add_new_line_cr', function(e){
                e.preventDefault();
                $.ajax({
                    url: '{{route('multi-cash-payment.add_new_line_cr')}}',
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        $(".entry_row_div_cr").append(response);
                        getMainAccount();
                        getPartners();
                        getWorkOrderList();
                        getWorkOrderSiteList();
                        getDebitAccount();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.delete_new_row_cr', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row_cr").remove();
                getSumAmount();
            });

            $(document).ready(function(){
                getDebitAccount();
                getMainAccount();
                getPartners();
                getWorkOrderList();
                getWorkOrderSiteList();
                getPrint();
            });

            function getPrint(){
                let v_id = $('#v_id').val();
                if (v_id != 0) {
                    window.open(v_id, 'window name', 'window settings')
                }
            }

            $(document).on('change','.voucher_type', function(){
                if ($(".voucher_type").val() == "rcv") {
                    $('.title_info').text("Credit")
                } else {
                    $('.title_info').text("Debit")
                }
            });

            function getMainAccount(){
                $(".debit_account_id").select2({
                    ajax: {
                        url: '{{route('ledger.transactional_list_for_select')}}',
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: "transactional",
                                    account_type: 4,
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

            function getDebitAccount(){
                $(".credit_account_id").select2({
                    ajax: {
                        url: '{{route('ledger.transactional_list_for_select')}}',
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: "cash",
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
                $(".credit_sub_account_id").select2({
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

            function getWorkOrderList()
            {
                $(".work_order_id").select2({
                    ajax: {
                        url: '{{route('work-order.list_for_select')}}',
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1
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

            function getWorkOrderSiteList()
            {
                $(".work_order_site_detail_id").select2({
                    ajax: {
                        url: '{{route('work-order-sites.list_for_select')}}',
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1
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
    
            var inputTimeout;
            $(document).on('keyup', '.debit_amount, .credit_amount', function(){
                if (inputTimeout) {
                    clearTimeout(inputTimeout);
                }
                inputTimeout = setTimeout(getSumAmount, 500);
            });

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
        })(jQuery);
    </script>
@endpush
@php
    if (session()->get('voucher_id')) {
        session()->forget('voucher_id');
    }
@endphp