@extends('layouts.admin_app')
@section('title')
Sale
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Edit Sale</h4></div>
        <div><a href="{{route('sales.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('sales.update', encrypt($product->id))}}">
                        @csrf
                        <div class="row">
                            <x-common.input :required="true" column=4 id="name" name="name" label="Product Name" placeholder="Product Name" :value="old('name',$product->name)"></x-common.input>
                            <x-common.server-side-select :required="true" column=4 name="product_unit_id" id="product_unit_id" class="product_unit_id" disableOptionText="Select One" label="Product Unit" :options="[
                                ['id' => $product->product_unit_id, 'name' => $product->product_unit->name]
                            ]" :value="$product->product_unit_id"></x-common.server-side-select>
                            <x-common.radio :required="true" column=4 name="type" class="type" label="Type" placeholder="Type" :value="$product->type" :options="[
                                ['id' => 'Service', 'name' => 'Service'],
                                ['id' => 'Product', 'name' => 'Product']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="for_selling" class="for_selling" label="For Selling" placeholder="For Selling" :value="$product->for_selling" :options="[
                                ['id' => 'Yes', 'name' => 'Yes'],
                                ['id' => 'No', 'name' => 'No']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="for_purchase" class="for_purchase" label="For Purchase" placeholder="For Purchase" :value="$product->for_purchase" :options="[
                                ['id' => 'Yes', 'name' => 'Yes'],
                                ['id' => 'No', 'name' => 'No']
                            ]"></x-common.radio>
                            <x-common.file-browse label="Image" :required="false" column=4 name="image" extension="application/image"></x-common.file-browse>
                            <x-common.server-side-select :required="true" column=6 name="purchase_ledger_id" id="purchase_ledger_id" class="purchase_ledger_id" disableOptionText="Select Ledger" label="Purchase Account" :options="[
                                ['id' => $product->purchase_ledger_id, 'name' => $product->purchase_ledger->name]
                            ]" :value="$product->purchase_ledger_id"></x-common.server-side-select>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=6 id="purchase_price" name="purchase_price" label="Purchase Price" placeholder="Purchase Price" :value="old('purchase_price', $product->purchase_price)"></x-common.input>
                            <x-common.server-side-select :required="true" column=6 name="selling_ledger_id" id="selling_ledger_id" class="selling_ledger_id" disableOptionText="Select Ledger" label="Selling Account" :options="[
                                ['id' => $product->selling_ledger_id, 'name' => $product->selling_ledger->name]
                            ]" :value="$product->selling_ledger_id"></x-common.server-side-select>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=6 id="selling_price" name="selling_price" label="Selling Price" placeholder="Selling Price" :value="old('selling_price', $product->selling_price)"></x-common.input>
                            <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="$product->is_active" :options="[
                                ['id' => 'Yes', 'name' => 'Active'],
                                ['id' => 'No', 'name' => 'In-Active']
                            ]"></x-common.radio>
                            <x-common.text-area :required="false" column=8 name="details" label="Details" placeholder="Details..." :value="$product->details"></x-common.text-area>
                        </div>
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
            
            $(".product_unit_id").select2({
                ajax: {
                    url: '{{route('products-unit.list_for_select')}}',
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
            
            $(".purchase_ledger_id").select2({
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
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            $(".selling_ledger_id").select2({
                ajax: {
                    url: '{{route('ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: "income",
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

        })(jQuery);
    </script>
@endpush