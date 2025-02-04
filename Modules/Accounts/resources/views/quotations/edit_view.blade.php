@extends('layouts.admin_app')
@section('title')
Edit Quotation
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Edit Quotation</h4></div>
        <div><a href="{{route('quotations.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('quotations.update', encrypt($quotation->id))}}">
                        @csrf
                        <div class="row mb-2">
                            <x-common.server-side-select :required="true" column=4 name="sub_ledger_id" id="sub_ledger_id" class="sub_ledger_id" disableOptionText="Select One" label="Vendor" :options="[
                                ['id' => $quotation->sub_ledger_id, 'name' => $quotation->sub_ledger->name]
                            ]" :value="$quotation->sub_ledger_id"></x-common.server-side-select>
                            <x-common.date-picker label="Date" :required="true" column=4 name="date" placeholder="Date" :value="date('d/m/Y', strtotime($quotation->date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                            <x-common.input :required="true" column=4 id="invoice_no" name="invoice_no" label="Invoice No" placeholder="Invoice No" :value="$quotation->invoice_no"></x-common.input>
                            <x-common.input :required="false" column=4 id="ref_no" name="ref_no" label="Reference No" placeholder="Reference No" :value="$quotation->ref_no"></x-common.input>
                            <x-common.input :required="false" column=4 id="phone" name="phone" label="Phone No" placeholder="Phone No" :value="$quotation->phone"></x-common.input>
                            <x-common.server-side-select :required="true" column=12 name="product_select_id" id="product_select_id" class="product_select_id" disableOptionText="Select Product" label="Product"></x-common.server-side-select>
                        </div>
                        <fieldset class="the-fieldset mb-3">
                            <legend class="the-legend">Quotation Details Information</legend>
                            <div class="entry_row_div mb-2">
                                @foreach ($quotation->quotation_details as $product)
                                    <div class="row new_added_row">
                                        <input type="hidden" name="product_id[]" value="{{$product->product_id}}">
                                        <x-common.input :required="true" column=4 name="name[]" label="Product Name" placeholder="Product Name" :value="$product->product->name"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=1 name="qty[]" class="qty" label="QTY" placeholder="QTY" :value="$product->quantity"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="sale_price_tax[]" class="sale_price_tax" label="Purchase Tax (%)" placeholder="0" :value="$product->tax"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="sale_price[]" class="sale_price" label="Purchase Price" placeholder="Purchase Price" :value="$product->per_price"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="total_sale_price[]" class="total_sale_price" label="Total Price" placeholder="Total Price" :value="$product->total_price"></x-common.input>
                                        <div class="col-md-1 mb-3">
                                            <label class="form-label" for=""> Action </label>
                                            <div>
                                                <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        <fieldset class="the-fieldset mb-2">
                            <legend class="the-legend">Payment Information</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <x-common.input :required="true" type="number" step="1" min="0" column=6 class="total_qty" name="total_qty" label="Total Qty" placeholder="0" :value="$quotation->quotation_details()->sum('quantity')"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="total_amount" name="total_amount" label="Total Amount" placeholder="0" :value="$quotation->total_amount"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="discount_amount" name="discount_amount" label="Discount in (%)" placeholder="0" :value="$quotation->discount_percentage"></x-common.input>
                                        <x-common.input :required="true" type="number" step="0.01" min="0" column=6 class="net_amount" name="net_amount" label="Net Amount" placeholder="0" :value="$quotation->payable_amount"></x-common.input>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <x-common.text-area :required="false" column=6 name="note" label="Note" placeholder="Note..." :value="$quotation->note"></x-common.text-area>
                            <x-common.text-editor label="Terms and Condition" :required="false" column=6 name="terms_condition" id="terms_condition" :value="$quotation->terms_condition"></x-common.text-editor>
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
                                is_selling: "yes"
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
                                type: "Client",
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
                    url: "{{ route('products.get_detail_sale') }}",
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

            $(document).on('keyup', '.qty, .sale_price, .sale_price_tax', function(e){
                e.preventDefault();
                let row = $(this).parent().parent();
                
                var sale_price = row.find('.sale_price').val();
                var sale_price_tax = row.find('.sale_price_tax').val();
                var qty = row.find('.qty').val();
                if (parseFloat(sale_price_tax) > 0) {
                    var sale_price_tax_amount = parseFloat(sale_price) * parseFloat(sale_price_tax) / 100;
                    row.find('.total_sale_price').val(((parseFloat(sale_price)+(parseFloat(sale_price_tax_amount))) * parseFloat(qty)).toFixed(2));
                } else {
                    row.find('.total_sale_price').val((parseFloat(sale_price) * parseFloat(qty)).toFixed(2));
                }
                sumTotalAmount();
            });

            function sumTotalAmount() {
                var total_amounts = $("input[name='total_sale_price[]']").map(function(){return $(this).val();}).get();
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