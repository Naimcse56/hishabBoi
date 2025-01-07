@extends('layouts.admin_app')
@section('title')
New Staff
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">New Staff</h4></div>
            <div><a href="{{route('staffs.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive">                        
                        <form method="POST" action="{{route('staffs.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-common.input :required="true" column=4 id="name" name="name" label="Full Name" placeholder="Full Name" :value="old('name')"></x-common.input>
                                <x-common.input :required="true" column=4 id="email" name="email" type="email" label="Email" placeholder="Email" :value="old('email')"></x-common.input>
                                <x-common.input :required="true" column=4 id="password" name="password" label="Password" placeholder="Password" :value="old('password')"></x-common.input>
                                <x-common.input :required="true" column=4 id="staff_id" name="staff_id" label="Staff ID" placeholder="Staff ID" :value="old('staff_id')"></x-common.input>
                                <x-common.server-side-select :required="true" column=4 name="department_id" id="department_id" class="department_id" disableOptionText="Select One" label="Department"></x-common.server-side-select>
                                <x-common.server-side-select :required="true" column=4 name="designation_id" id="designation_id" class="designation_id" disableOptionText="Select One" label="Designation"></x-common.server-side-select>
                                <x-common.input :required="true" column=4 id="phone" name="phone" label="Phone" placeholder="Phone" :value="old('phone')"></x-common.input>
                                <x-common.input :required="false" column=4 id="alternate_phone" name="alternate_phone" label="Alternate Phone" placeholder="Alternate Phone" :value="old('alternate_phone')"></x-common.input>
                                <x-common.date-picker label="Date of Birth" :required="true" column=4 name="date_of_birth" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.date-picker label="Joining Date" :required="true" column=4 name="joining_date" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.file-browse label="NID" :required="false" column=4 name="nid" extension="application/image"></x-common.file-browse>
                                <x-common.file-browse label="CV / Resume" :required="false" column=4 name="cv" extension="application/image"></x-common.file-browse>
                                <x-common.text-area :required="false" column=4 name="present_address" label="Present Address" placeholder="Present Address..."></x-common.text-area>
                                <x-common.text-area :required="false" column=4 name="permanant_address" label="Permanant Address" placeholder="Permanant Address..."></x-common.text-area>
                                <x-common.text-area :required="false" column=4 name="remarks" label="Remarks" placeholder="Remarks..."></x-common.text-area>
                                <x-common.radio :required="true" column=4 name="employement_status" class="employement_status" label="Employement Status" placeholder="Employement Status" :value="'Provision'" :options="[
                                    ['id' => 'Provision', 'name' => 'Provision'],
                                    ['id' => 'Permanant', 'name' => 'Permanant'],
                                    ['id' => 'Contractual', 'name' => 'Contractual']
                                ]"></x-common.radio>
                                <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="'Yes'" :options="[
                                    ['id' => 'Yes', 'name' => 'Active'],
                                    ['id' => 'No', 'name' => 'In-Active']
                                ]"></x-common.radio>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="the-fieldset mt-2">
                                        <legend class="the-legend">Ledger Information</legend>
                                        <div class="row">
                                            <x-common.server-side-select :required="true" column=4 name="ledger_id" id="ledger_id" class="ledger_id" disableOptionText="Select One" label="Ledger Account"></x-common.server-side-select>
                                            <x-common.select :required="false" column=4 name="sub_ledger_type_id" id="sub_ledger_type_id" class="sub_ledger_type_id" disableOptionText="Select Type" label="Staff Type" :options=$sub_ledger_types></x-common.select>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="the-fieldset mt-2">
                                        <legend class="the-legend">Bank Information</legend>
                                        <div class="row">
                                            <x-common.input :required="false" column=4 id="bank_name" name="bank_name" label="Bank Name" placeholder="Bank Name" :value="old('bank_name')"></x-common.input>
                                            <x-common.input :required="false" column=4 id="bank_ac_name" name="bank_ac_name" label="Bank Account Name" placeholder="Bank Account Name" :value="old('bank_ac_name')"></x-common.input>
                                            <x-common.input :required="false" column=4 id="routing_no" name="routing_no" label="Routing No" placeholder="Routing No" :value="old('routing_no')"></x-common.input>
                                            <x-common.input :required="false" column=4 id="ac_no" name="ac_no" label="Bank Account No" placeholder="Bank Account No" :value="old('ac_no')"></x-common.input>
                                            <x-common.input :required="false" column=4 id="swift_code" name="swift_code" label="Swift Code" placeholder="Swift Code" :value="old('swift_code')"></x-common.input>
                                            <x-common.input :required="false" column=4 id="branch_code" name="branch_code" label="Branch Code" placeholder="Branch Code" :value="old('branch_code')"></x-common.input>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <x-common.button column=12 type="submit" id="update-btn" class="btn-primary btn-120 update-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
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
            $(".department_id").select2({
                ajax: {
                    url: '{{route('departments.list_for_select')}}',
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
            $(".designation_id").select2({
                ajax: {
                    url: '{{route('designation.list_for_select')}}',
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
        })(jQuery);
    </script>
@endpush