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
                            <x-common.server-side-select :required="true" column=4 name="parent_id" id="parent_id" class="parent_id" disableOptionText="Select Parent" label="Parent Account"></x-common.server-side-select>
                            <x-common.input :required="true" column=4 id="name" name="name" label="Account Head" placeholder="Account Head" :value="old('name')"></x-common.input>
                            <x-common.input :required="true" column=4 id="code" name="code" label="Account Code" placeholder="Account Code" :value="old('code')"></x-common.input>
                            <x-common.radio :required="true" column=4 name="acc_type" class="acc_type" label="Ledger Type" placeholder="Ledger Type" :value="'others'" :options="[
                                ['id' => 'cash', 'name' => 'Cash'],
                                ['id' => 'bank', 'name' => 'Bank'],
                                ['id' => 'others', 'name' => 'Others']
                            ]"></x-common.radio>
                            <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="1" :options="[
                                ['id' => 1, 'name' => 'Active'],
                                ['id' => 0, 'name' => 'Inactive']
                            ]"></x-common.radio>
                        </div>
                            
                        <div class="row ac_no_div d-none">
                            <div class="col-md-12 general_config_div">
                                <fieldset class="the-fieldset mt-2">
                                    <legend class="the-legend">Bank Information</legend>
                                    <div class="row">
                                        <x-common.input :required="true" column=4 id="bank_ac_name" name="bank_ac_name" label="Bank Account Name" placeholder="Bank Account Name" :value="old('bank_ac_name')"></x-common.input>
                                        <x-common.input :required="true" column=4 id="ac_no" name="ac_no" label="Bank Account No" placeholder="Bank Account No" :value="old('ac_no')"></x-common.input>
                                        <x-common.input :required="true" column=4 id="routing_no" name="routing_no" label="Routing No" placeholder="Routing No" :value="old('routing_no')"></x-common.input>
                                        <x-common.input :required="true" column=4 id="swift_code" name="swift_code" label="Swift Code" placeholder="Swift Code" :value="old('swift_code')"></x-common.input>
                                        <x-common.input :required="true" column=4 id="branch_code" name="branch_code" label="Branch Code" placeholder="Branch Code" :value="old('branch_code')"></x-common.input>
                                        <x-common.input :required="true" column=4 id="bank_address" name="bank_address" label="Bank Address" placeholder="Bank Address" :value="old('bank_address')"></x-common.input>
                                    </div>
                                </fieldset>
                            </div>
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
            
            $(".parent_id").select2({
                ajax: {
                    url: '{{route('products.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
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

        })(jQuery);
    </script>
@endpush