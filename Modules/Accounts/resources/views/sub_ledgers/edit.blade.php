@extends('layouts.admin_app')
@section('title')
Party Accounts
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Edit Party Account</h4></div>
        <div><a href="{{route('sub-ledger.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('sub-ledger.update', encrypt($item->id))}}">
                        @csrf
                        <div class="row">
                            <x-common.server-side-select :required="true" column=4 name="ledger_id" id="ledger_id" class="ledger_id" disableOptionText="Select Parent" label="Parent Account" :options="[
                                ['id' => $item->ledger_id, 'name' => $item->ledger->name]
                            ]" :value="$item->ledger_id"></x-common.server-side-select>
                            <x-common.input :required="true" column=4 id="name" name="name" label="Party Name" placeholder="Party Name" :value="old('name',$item->name)"></x-common.input>
                            <x-common.input :required="true" column=4 id="code" name="code" label="Party Code / Mobile" placeholder="Party Code / Mobile" :value="old('code',$item->code)"></x-common.input>
                            <x-common.input :required="false" column=4 id="email" name="email" label="Party Email" placeholder="Party Email" :value="old('email',$item->email)"></x-common.input>
                            <x-common.radio :required="true" column=4 name="type" class="type" label="Type" placeholder="Type" :value="$item->type" :options="[
                                ['id' => 'Client', 'name' => 'Client'],
                                ['id' => 'Vendor', 'name' => 'Vendor'],
                                ['id' => 'Staff', 'name' => 'Staff']
                                ]"></x-common.radio>
                            <x-common.select :required="false" column=4 name="sub_ledger_type_id" id="sub_ledger_type_id" class="sub_ledger_type_id" disableOptionText="Select Type" label="Party Type" :value="$item->sub_ledger_type_id" :options=$sub_ledger_types></x-common.select>
                            <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="$item->is_active" :options="[
                                ['id' => 1, 'name' => 'Active'],
                                ['id' => 0, 'name' => 'Inactive']
                            ]"></x-common.radio>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="the-fieldset mt-2">
                                    <legend class="the-legend">Bank Information</legend>
                                    <div class="row">
                                        <x-common.input :required="false" column=4 id="bank_name" name="bank_name" label="Bank Name" placeholder="Bank Name" :value="old('bank_name',$item->bank_name)"></x-common.input>
                                        <x-common.input :required="false" column=4 id="bank_ac_name" name="bank_ac_name" label="Bank Account Name" placeholder="Bank Account Name" :value="old('bank_ac_name',$item->bank_ac_name)"></x-common.input>
                                        <x-common.input :required="false" column=4 id="routing_no" name="routing_no" label="Routing No" placeholder="Routing No" :value="old('routing_no',$item->routing_no)"></x-common.input>
                                        <x-common.input :required="false" column=4 id="ac_no" name="ac_no" label="Bank Account No" placeholder="Bank Account No" :value="old('ac_no',$item->ac_no)"></x-common.input>
                                        <x-common.input :required="false" column=4 id="swift_code" name="swift_code" label="Swift Code" placeholder="Swift Code" :value="old('swift_code',$item->swift_code)"></x-common.input>
                                        <x-common.input :required="false" column=4 id="branch_code" name="branch_code" label="Branch Code" placeholder="Branch Code" :value="old('branch_code',$item->branch_code)"></x-common.input>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-12 mt-2">
                                <fieldset class="the-fieldset mt-2">
                                    <legend class="the-legend">Other Information</legend>
                                    <div class="row">
                                        <x-common.input :required="false" column=4 id="tin" name="tin" label="TIN" placeholder="TIN" :value="old('tin')"></x-common.input>
                                        <x-common.input :required="false" column=4 id="bin" name="bin" label="BIN" placeholder="BIN" :value="old('bin')"></x-common.input>
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
            $(".ledger_id").select2({
                ajax: {
                    url: '{{route('ledger.transactional_list_for_select')}}',
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