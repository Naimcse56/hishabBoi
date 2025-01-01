@extends('layouts.admin_app')
@section('title')
Configurations
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Report Configuration</h4></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('accountings.general-config-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <fieldset class="the-fieldset mt-2">
                                <legend class="the-legend">Income Statement Section</legend>
                                <div class="row">
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_first_section')->first()->value);
                                    @endphp
                                    <input type="hidden" name="field_name[]" value="inc_st_first_section">
                                    <input type="hidden" name="field_name[]" value="inc_st_second_section">
                                    <input type="hidden" name="field_name[]" value="inc_st_third_section">
                                    <input type="hidden" name="field_name[]" value="inc_st_fourth_section">
                                    <input type="hidden" name="field_name[]" value="inc_st_fifth_section">
                                    <input type="hidden" name="field_name[]" value="inc_st_tax_expenses_section">
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_first_section" class="account_id" disableOptionText="Select Ledger" label="1st Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_second_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_second_section" class="account_id" disableOptionText="Select Ledger" label="2nd Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_third_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_third_section" class="account_id" disableOptionText="Select Ledger" label="3rd Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_fourth_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_fourth_section" class="account_id" disableOptionText="Select Ledger" label="4th Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_fifth_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_fifth_section" class="account_id" disableOptionText="Select Ledger" label="5th Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','inc_st_tax_expenses_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="inc_st_tax_expenses_section" class="account_id" disableOptionText="Select Ledger" label="TAX Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                </div>
                            </fieldset>
                            <fieldset class="the-fieldset mt-2">
                                <legend class="the-legend">Balance Sheet Report Section</legend>
                                <div class="row">
                                    <input type="hidden" name="field_name[]" value="balance_sht_first_section">
                                    <input type="hidden" name="field_name[]" value="balance_sht_second_section">
                                    <input type="hidden" name="field_name[]" value="balance_sht_third_section">
                                    <input type="hidden" name="field_name[]" value="balance_sht_fourth_section">
                                    <input type="hidden" name="field_name[]" value="balance_sht_fifth_section">
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','balance_sht_first_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="balance_sht_first_section" class="account_id" disableOptionText="Select Ledger" label="1st Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','balance_sht_second_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="balance_sht_second_section" class="account_id" disableOptionText="Select Ledger" label="2nd Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','balance_sht_third_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="balance_sht_third_section" class="account_id" disableOptionText="Select Ledger" label="3rd Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','balance_sht_fourth_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="balance_sht_fourth_section" class="account_id" disableOptionText="Select Ledger" label="4th Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                    @php
                                        $account = Modules\Accounts\App\Models\Ledger::find($settings->where('name','balance_sht_fifth_section')->first()->value);
                                    @endphp
                                    <x-common.server-side-select :required="true" column=4 name="balance_sht_fifth_section" class="account_id" disableOptionText="Select Ledger" label="5th Section Ledger" :options="[
                                        ['id' => $account->id, 'name' => $account->name]
                                    ]" :value="$account->id"></x-common.server-side-select>
                                </div>
                            </fieldset>
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
            $(".account_id").select2({
                ajax: {
                    url: "{{route('ledger.transactional_list_for_select')}}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: $('.journal_type').find(':selected').val(),
                                view:'ledger'
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