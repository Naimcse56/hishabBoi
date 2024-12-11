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
                            <x-common.input :required="false" column=4 id="phone" name="phone" label="Reference No" placeholder="Reference No" :value="old('phone')"></x-common.input>
                            <x-common.server-side-select :required="true" column=12 name="product_select_id" id="product_select_id" class="product_select_id" disableOptionText="Select Product" label="Product"></x-common.server-side-select>
                        </div>                        
                        <fieldset class="the-fieldset mb-3">
                            <legend class="the-legend">Purchase Details Information</legend>
                            <div class="entry_row_div">
                            </div>
                        </fieldset>
                        
                        <fieldset class="the-fieldset mb-2">
                            <legend class="the-legend">Payment Information</legend>
                            <div class="row">
                                <x-common.radio :required="true" column=4 name="payment_method" class="payment_method" label="Payment Method" placeholder="Payment Method" :value="'Cash'" :options="[
                                    ['id' => 'Cash', 'name' => 'Cash'],
                                    ['id' => 'Bank', 'name' => 'Bank'],
                                    ['id' => 'Online', 'name' => 'Online']
                                ]"></x-common.radio>
                                <x-common.radio :required="true" column=4 name="payment_status" class="payment_status" label="Payment Status" placeholder="Payment Status" :value="'Due'" :options="[
                                    ['id' => 'Due', 'name' => 'Due'],
                                    ['id' => 'Paid', 'name' => 'Paid'],
                                    ['id' => 'Partial', 'name' => 'Partial']
                                ]"></x-common.radio>
                                </div>
                        </fieldset>
                        <div class="row">
                            <x-common.text-area :required="false" column=8 name="note" label="Note" placeholder="Note..."></x-common.text-area>
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
                    }
                });
            });

        })(jQuery);
    </script>
@endpush