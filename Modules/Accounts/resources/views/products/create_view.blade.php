@extends('layouts.admin_app')
@section('title')
New Product
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">New Product</h4></div>
        <div><a href="{{route('products.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('products.store')}}">
                        @csrf
                        <div class="row">
                            <x-common.input :required="true" column=4 id="name" name="name" label="Product Name" placeholder="Product Name" :value="old('name')"></x-common.input>
                            <x-common.server-side-select :required="true" column=4 name="product_unit_id" id="product_unit_id" class="product_unit_id" disableOptionText="Select One" label="Product Unit"></x-common.server-side-select>
                            <x-common.radio :required="true" column=4 name="type" class="type" label="Type" placeholder="Type" :value="'Product'" :options="[
                                ['id' => 'Service', 'name' => 'Service'],
                                ['id' => 'Product', 'name' => 'Product']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="for_selling" class="for_selling" label="For Selling" placeholder="For Selling" :value="'Yes'" :options="[
                                ['id' => 'Yes', 'name' => 'Yes'],
                                ['id' => 'No', 'name' => 'No']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="for_purchase" class="for_purchase" label="For Purchase" placeholder="For Purchase" :value="'Yes'" :options="[
                                ['id' => 'Yes', 'name' => 'Yes'],
                                ['id' => 'No', 'name' => 'No']
                            ]"></x-common.radio>
                            <x-common.file-browse label="Image" :required="false" column=4 name="image" extension="application/image"></x-common.file-browse>
                            <x-common.server-side-select :required="true" column=4 name="purchase_ledger_id" id="purchase_ledger_id" class="purchase_ledger_id" disableOptionText="Select Ledger" label="Purchase Account"></x-common.server-side-select>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=4 id="purchase_price" name="purchase_price" label="Purchase Price" placeholder="Purchase Price" :value="old('purchase_price', 0)"></x-common.input>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=4 id="purchase_price_tax" name="purchase_price_tax" label="Purchase Price Tax (%)" placeholder="Purchase Price Tax (%)" :value="old('purchase_price_tax', 0)"></x-common.input>
                            <x-common.server-side-select :required="true" column=4 name="selling_ledger_id" id="selling_ledger_id" class="selling_ledger_id" disableOptionText="Select Ledger" label="Selling Account"></x-common.server-side-select>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=4 id="selling_price" name="selling_price" label="Selling Price" placeholder="Selling Price" :value="old('selling_price', 0)"></x-common.input>
                            <x-common.input :required="true" type="number" step="0.01" min="0" column=4 id="selling_price_tax" name="selling_price_tax" label="Selling Price Tax (%)" placeholder="Selling Price Tax (%)" :value="old('selling_price_tax', 0)"></x-common.input>
                            <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="'Yes'" :options="[
                                ['id' => 'Yes', 'name' => 'Active'],
                                ['id' => 'No', 'name' => 'In-Active']
                            ]"></x-common.radio>
                            <x-common.text-area :required="false" column=8 name="details" label="Details" placeholder="Details..."></x-common.text-area>
                        </div>
                        <div class="row">
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