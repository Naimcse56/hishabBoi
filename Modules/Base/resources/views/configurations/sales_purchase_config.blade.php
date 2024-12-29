@extends('layouts.admin_app')
@section('title')
Terms & Condition Settings
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Terms & Condition Settings</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('base_settings_update.configurations')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @php
                                    $purchase_discount_ledger = Modules\Accounts\App\Models\Ledger::find($settings->where('name','purchase_discount_ledger')->first()->value);
                                    $sales_discount_ledger = Modules\Accounts\App\Models\Ledger::find($settings->where('name','sales_discount_ledger')->first()->value);
                                @endphp
                                <x-common.server-side-select :required="true" column=6 name="purchase_discount_ledger" class="purchase_discount_ledger" disableOptionText="Select Account" label="Purchase Discount Ledger Account" :options="[
                                        ['id' => $purchase_discount_ledger->id, 'name' => $purchase_discount_ledger->name]
                                    ]" :value="$purchase_discount_ledger->id"></x-common.server-side-select>
                                <x-common.server-side-select :required="true" column=6 name="sales_discount_ledger" class="sales_discount_ledger" disableOptionText="Select Account" label="Sale Discount Ledger Account" :options="[
                                        ['id' => $sales_discount_ledger->id, 'name' => $sales_discount_ledger->name]
                                    ]" :value="$sales_discount_ledger->id"></x-common.server-side-select>
                                <x-common.text-editor label="Purchase Terms and Condition" :required="false" column=6 name="purchase_terms_condition" id="purchase_terms_condition" :value="app('general_setting')['purchase_terms_condition']"></x-common.text-editor>
                                <x-common.text-editor label="Sales Terms and Condition" :required="false" column=6 name="sale_terms_condition" id="sale_terms_condition" :value="app('general_setting')['sale_terms_condition']"></x-common.text-editor>
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
            $(".purchase_discount_ledger").select2({
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
            $(".sales_discount_ledger").select2({
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