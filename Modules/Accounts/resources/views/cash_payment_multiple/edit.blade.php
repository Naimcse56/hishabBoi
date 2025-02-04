@extends('layouts.admin_app')
@section('title')
Cash Voucher
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Edit Cash Voucher</h4></div>
            <div><a href="{{route('multi-cash-payment.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="journal_create_form" method="POST" enctype="multipart/form-data" action="{{route('multi-cash-payment.update', encrypt($journal->id))}}">
                            @csrf
                            <div class="row">
                                <x-common.date-picker label="Date" :required="true" column=4 name="date" placeholder="Date" :value="date('d/m/Y', strtotime($journal->date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.input :required="false" column=4 id="concern_person" name="concern_person" label="Concern Person" placeholder="Concern Person" :value="old('concern_person', $journal->concern_person)"></x-common.input>
                                <x-common.select :required="true" column=4 name="pay_or_rcv_type" class="pay_or_rcv_type" label="Type" placeholder="Type" :value="$journal->pay_or_rcv_type" :options="[
                                    ['id' => 'Cash', 'name' => 'Cash']
                                ]"></x-common.select>
                                <x-common.server-side-select :required="false" column=4 name="purchase_id" id="purchase_id" class="purchase_id" disableOptionText="Select One" label="Purchase Invoice"></x-common.server-side-select>
                                <x-common.text-area :required="false" column=12 name="narration" label="Purpose / Narration" placeholder="Remarks..." :value="$journal->narration"></x-common.text-area>
                            </div>
                            <div class="sales-voucher mb-4">
                                <fieldset class="the-fieldset mb-4">
                                    <legend class="the-legend fw-semibold bg-danger-subtle">Payment Information</legend>
                                    <div class="entry_row_div_cr">
                                        @foreach ($transactions as $trans_account)
                                        <div class="row new_added_row_cr">                                    
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <x-common.server-side-select :required="true" column=4 name="credit_account_id[]" class="credit_account_id" disableOptionText="Select Credit Account" label="Credit Accounts" :options="[
                                                        ['id' => $trans_account['cr_account_id'], 'name' => $trans_account['cr_account_name']]
                                                    ]" :value="$trans_account['cr_account_id']"></x-common.server-side-select>
                                                    <x-common.server-side-select :required="false" column=4 name="credit_sub_account_id[]" class="credit_sub_account_id" disableOptionText="Select Party Account" label="Party Accounts (Cr)" :options="[
                                                        ['id' => $trans_account['cr_party_account_id'], 'name' => $trans_account['cr_party_account_name']]
                                                    ]" :value="$trans_account['cr_party_account_id']"></x-common.server-side-select>
                                                    <x-common.input :required="true" column=4 name="credit_amount[]" type="number" step="0.01" label="Amount" placeholder="Amount" :value="$trans_account['amount']"></x-common.input>
                                                    <x-common.server-side-select :required="true" column=4 name="debit_account_id[]" class="debit_account_id" disableOptionText="Select Debit Account" label="Debit Accounts" :options="[
                                                        ['id' => $trans_account['dr_account_id'], 'name' => $trans_account['dr_account_name']]
                                                    ]" :value="$trans_account['dr_account_id']"></x-common.server-side-select>
                                                    <x-common.server-side-select :required="false" column=4 name="debit_sub_account_id[]" class="credit_sub_account_id" disableOptionText="Select Party Account" label="Party Accounts (Dr)" :options="[
                                                        ['id' => $trans_account['dr_party_account_id'], 'name' => $trans_account['dr_party_account_name']]
                                                    ]" :value="$trans_account['dr_party_account_id']"></x-common.server-side-select>
                                                    <x-common.server-side-select :required="false" column=4 name="work_order_id[]" class="work_order_id" disableOptionText="Select Work Order" label="Work Order" :options="[
                                                        ['id' => $trans_account['work_order_id'], 'name' => $trans_account['work_order_name']]
                                                    ]" :value="$trans_account['work_order_id']"></x-common.server-side-select>
                                                    <x-common.server-side-select :required="false" column=4 name="work_order_site_detail_id[]" class="work_order_site_detail_id" disableOptionText="Select Work Order Site" label="Work Order Site" :options="[
                                                        ['id' => $trans_account['work_order_site_id'], 'name' => $trans_account['work_order_site_name']]
                                                    ]" :value="$trans_account['work_order_site_id']"></x-common.server-side-select>
                                                    
                                                    <div class="col-md-1 mb-3">
                                                        <label class="form-label" for=""> Action </label>
                                                        <div>
                                                            <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row_cr"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="row">
                                                    <x-common.text-area :required="false" column=12 name="credit_narration[]" label="Purpose / Narration" placeholder="Remarks..." :value="$trans_account['dr_narration']"></x-common.text-area>
                                                </div>
                                            </div><hr>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label" for="Total Amount">Total Amount :</label>
                                            <label class="form-label total_credit_amount text-danger" for="Cr Amount">0.00</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ms-auto">
                                            <a href="javascript:;" class="btn btn-sm btn-success text-white" id="add_new_line_cr">Add New Row (CR)</a>
                                        </div>
                                    </div>
                                </div>
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
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;
            $(".purchase_id").select2({
                ajax: {
                    url: '{{route('purchases.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                filter_for: "payment",
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

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
            });

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
                                    page: params.page || 1,
                                    sub_ledger_id: $(".wo_client").val()
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
                                    page: params.page || 1,
                                    work_order_id: $(".work_order_id").val()
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