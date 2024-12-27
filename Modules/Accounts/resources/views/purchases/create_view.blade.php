@extends('layouts.admin_app')
@section('title')
New Purchase
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">New Purchase</h4></div>
        <div><a href="{{route('purchases.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('purchases.store')}}">
                        @csrf
                        <div class="row mb-2">
                            <x-common.server-side-select :required="true" column=4 name="sub_ledger_id" id="sub_ledger_id" class="sub_ledger_id" disableOptionText="Select One" label="Vendor"></x-common.server-side-select>
                            <x-common.date-picker label="Date" :required="true" column=4 name="date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                            <x-common.input :required="true" column=4 id="invoice_no" name="invoice_no" label="Invoice No" placeholder="Invoice No" :value="old('invoice_no')"></x-common.input>
                            <x-common.input :required="false" column=4 id="ref_no" name="ref_no" label="Reference No" placeholder="Reference No" :value="old('ref_no')"></x-common.input>
                            <x-common.input :required="true" column=4 id="phone" name="phone" label="Phone No" placeholder="Phone No" :value="old('phone')"></x-common.input>
                            <x-common.server-side-select :required="false" column=4 name="work_order_id" class="work_order_id" disableOptionText="Select Work Order" label="Work Order"></x-common.server-side-select>
                            <x-common.server-side-select :required="false" column=4 name="work_order_site_detail_id" class="work_order_site_detail_id" disableOptionText="Select Work Order Site" label="Work Order Site"></x-common.server-side-select>
                            <x-common.server-side-select :required="true" column=8 name="product_select_id" id="product_select_id" class="product_select_id" disableOptionText="Select Product" label="Product"></x-common.server-side-select>
                        </div>
                        <fieldset class="the-fieldset mb-3">
                            <legend class="the-legend">Purchase Details Information</legend>
                            <div class="entry_row_div mb-2">

                            </div>
                        </fieldset>
                        <fieldset class="the-fieldset mb-2">
                            <legend class="the-legend">Payment Information</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <x-common.input :required="true" type="number" step="1" min="0" column=6 class="total_qty" name="total_qty" label="Total Qty" placeholder="0" :value="old('total_qty', 0)"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="total_amount" name="total_amount" label="Total Amount" placeholder="0" :value="old('total_amount', 0)"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="discount_amount" name="discount_amount" label="Discount in (%)" placeholder="0" :value="old('discount_amount', 0)"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="net_amount" name="net_amount" label="Net Amount" placeholder="0" :value="old('net_amount', 0)"></x-common.input>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <x-common.radio :required="true" column=6 name="payment_method" class="payment_method" label="Payment Method" placeholder="Payment Method" :value="'Cash'" :options="[
                                            ['id' => 'Cash', 'name' => 'Cash'],
                                            ['id' => 'Bank', 'name' => 'Bank'],
                                            ['id' => 'Online', 'name' => 'Online']
                                        ]"></x-common.radio>
                                        <x-common.radio :required="true" column=6 name="payment_status" class="payment_status" label="Payment Status" placeholder="Payment Status" :value="'Due'" :options="[
                                            ['id' => 'Due', 'name' => 'Due'],
                                            ['id' => 'Paid', 'name' => 'Paid'],
                                            ['id' => 'Partial', 'name' => 'Partial']
                                        ]"></x-common.radio>
                                        
                                        <x-common.input :required="true" type="number" step="1" min="0" column=6 id="credit_period" name="credit_period" label="Credit Period" placeholder="Credit Period" :value="old('credit_period', 0)"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 id="payment_amount" name="payment_amount" label="Payment Amount" placeholder="Payment Amount" :value="old('payment_amount', 0)"></x-common.input>
                                        <x-common.server-side-select :required="false" column=12 name="credit_account_id" class="credit_account_id" disableOptionText="Select Account" label="Payment From Account"></x-common.server-side-select>
                                        <x-common.input :required="false" column=6 id="bank_name" name="bank_name" label="Bank Name" placeholder="Bank Name" :value="old('bank_name')"></x-common.input>
                                        <x-common.input :required="false" column=6 id="bank_account_name" name="bank_account_name" label="Bank Account Name" placeholder="Bank Account Name" :value="old('bank_account_name')"></x-common.input>
                                        <x-common.input :required="false" column=6 id="check_no" name="check_no" label="Cheque No" placeholder="Cheque No" :value="old('check_no')"></x-common.input>
                                        <x-common.date-picker label="Check Maturity Date" :required="false" column=6 name="check_mature_date" placeholder="Check Maturity Date" :value="date('d/m/Y')" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <x-common.text-area :required="false" column=6 name="note" label="Note" placeholder="Note..."></x-common.text-area>
                            <x-common.text-editor label="Terms and Condition" :required="false" column=6 name="terms_condition" id="terms_condition" :value="app('general_setting')['purchase_terms_condition']"></x-common.text-editor>
                            <x-common.button column=12 type="submit" id="update_btn" class="btn-primary btn-120" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
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
                                sub_ledger_id: 0,
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
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
                                type: "cash_bank",
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
            $(".product_select_id").select2({
                ajax: {
                    url: '{{route('products.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                is_purchase: "yes"
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            $(".sub_ledger_id").select2({
                ajax: {
                    url: '{{route('sub-ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: "Vendor",
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

            $(document).on('change', '.product_select_id', function(){
                var id = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "{{ route('products.get_detail_purchase') }}",
                    data: {
                        id: id,
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        $('.entry_row_div').append(result);
                        sumTotalAmount();
                    }
                });
            });

            $(document).on('keyup', '.qty, .purchase_price, .purchase_price_tax', function(e){
                e.preventDefault();
                let row = $(this).parent().parent();
                
                var purchase_price = row.find('.purchase_price').val();
                var purchase_price_tax = row.find('.purchase_price_tax').val();
                var qty = row.find('.qty').val();
                if (parseFloat(purchase_price_tax) > 0) {
                    var purchase_price_tax_amount = parseFloat(purchase_price) * parseFloat(purchase_price_tax) / 100;
                    row.find('.total_purchase_price').val(((parseFloat(purchase_price)+(parseFloat(purchase_price_tax_amount))) * parseFloat(qty)).toFixed(2));
                } else {
                    row.find('.total_purchase_price').val((parseFloat(purchase_price) * parseFloat(qty)).toFixed(2));
                }
                sumTotalAmount();
            });

            function sumTotalAmount() {
                var total_amounts = $("input[name='total_purchase_price[]']").map(function(){return $(this).val();}).get();
                var total_amounts_sum = 0;
                for (var i = 0; i < total_amounts.length; i++) {
                    total_amounts_sum = parseFloat(total_amounts_sum) + parseFloat(total_amounts[i]);
                }
                $('.total_amount').val(total_amounts_sum.toFixed(2));
                sumTotalQty();
            }

            function sumTotalQty() {
                var total_qty = $("input[name='qty[]']").map(function(){return $(this).val();}).get();
                var total_qty_sum = 0;
                for (var i = 0; i < total_qty.length; i++) {
                    total_qty_sum = parseFloat(total_qty_sum) + parseFloat(total_qty[i]);
                }
                $('.total_qty').val(total_qty_sum.toFixed(2));
                sumTotalNetAmount();
            }

            function sumTotalNetAmount() {
                var total_amount = $(".total_amount").val();
                var discount_percent = $(".discount_amount").val();
                if (parseFloat(discount_percent) > 0) {
                    var discount_amount = parseFloat(total_amount) * parseFloat(discount_percent) / 100;
                    var net_amount = parseFloat(total_amount) - parseFloat(discount_amount);
                } else {
                    var net_amount = parseFloat(total_amount);   
                }             
                $('.net_amount').val(net_amount.toFixed(2));
            }

            $(document).on('keyup', '.discount_amount', function(e){
                sumTotalNetAmount();
            });
            $(document).on('click', '.delete_new_row', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row").remove();
                sumTotalAmount();
                sumTotalQty();
                sumTotalNetAmount();
            });
        })(jQuery);
    </script>
@endpush