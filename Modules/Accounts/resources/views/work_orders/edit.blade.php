@extends('layouts.admin_app')
@section('title')
Work Order
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Edit Work Order</h4></div>
            <div><a href="{{route('work-order.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('work-order.update', encrypt($item->id))}}">
                            @csrf
                            <div class="row">
                                <x-common.server-side-select :required="true" column=4 name="sub_ledger_id" id="sub_ledger_id" class="sub_ledger_id" disableOptionText="Select Client" label="Client" :options="[
                                    ['id' => $item->sub_ledger_id, 'name' => $item->sub_ledger->name]
                                ]" :value="$item->sub_ledger_id"></x-common.server-side-select>
                                <x-common.input :required="true" column=4 id="order_name" name="order_name" label="Work Order Name" placeholder="Work Order Name" :value="old('order_name',$item->order_name)"></x-common.input>
                                <x-common.input :required="true" column=4 id="order_no" name="order_no" label="Work Order No." placeholder="Work Order No." :value="old('order_no',$item->order_no)"></x-common.input>
                                <x-common.input :required="true" column=4 id="order_value" name="order_value" type="number" step="0.01" label="Work Order Value" placeholder="Work Order Value" :value="old('order_value',$item->order_value)"></x-common.input>
                                <x-common.input :required="true" column=4 id="awarded_by" name="awarded_by" label="Awarded By" placeholder="Awarded By" :value="old('awarded_by', $item->awarded_by)"></x-common.input>
                                <x-common.radio :required="true" column=4 name="is_active" class="is_active" label="Status" placeholder="Status" :value="$item->is_active" :options="[
                                    ['id' => 1, 'name' => 'Active'],
                                    ['id' => 0, 'name' => 'Inactive']
                                ]"></x-common.radio>
                                <x-common.date-picker label="Work Order Date" :required="true" column=4 name="create_date" placeholder="Work Order Date" :value="date('d/m/Y', strtotime($item->date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.date-picker label="Work Order Close Date" :required="true" column=4 name="end_date" placeholder="Work Order Close Date" :value="date('d/m/Y', strtotime($item->final_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.text-area :required="false" column=12 name="remarks" label="Remarks" placeholder="Remarks..." :value="$item->remarks"></x-common.text-area>                                
                            </div>
                            
                            <fieldset class="the-fieldset mt-4">
                                <legend class="the-legend">Estimation Cost Information</legend>
                                <div class="entry_row_div">
                                    @foreach ($item->work_order_estimation_costs as $estimation_cost)
                                        <div class="row new_added_row">
                                            <x-common.server-side-select :required="true" column=8 name="cost_type[]" class="cost_account_id" disableOptionText="Select Cost Type" label="Cost Type" :options="[
                                                ['id' => $estimation_cost->ledger_id, 'name' => $estimation_cost->ledger->name]
                                            ]" :value="$estimation_cost->ledger_id"></x-common.server-side-select>
                                            <x-common.input :required="true" column=3 name="cost_amounts[]" type="number" step="0.01" label="Cost Amount" placeholder="Cost Amount" :value="$estimation_cost->estimated_amount"></x-common.input>
                                            <div class="col-md-1 mb-3">
                                                <div class="d-block">
                                                    <label class="form-label" for=""> Action </label>
                                                    <div>
                                                        <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ms-auto">
                                            <a href="javascript:;" class="btn btn-sm btn-primary" id="add_new_line">Add New Estimation</a>
                                        </div>
                                    </div>
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
            $(document).ready(function(){
                $('.date').datepicker({ dateFormat: 'dd/mm/yy' });
                getMainAccountCreate();
                getCostAccount();
            });

            function getMainAccountCreate(){
                $(".account_id").select2({
                    ajax: {
                        url: "{{route('sub-ledger.transactional_list_for_select')}}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: 'customer',
                                }
                                return query;
                        },
                        cache: false
                    },
                    // dropdownParent: $('#exampleLargeModal'),
                });
            }

            function getCostAccount(){
                $(".cost_account_id").select2({
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
                                    account_type: 3,
                                }
                                return query;
                        },
                        cache: false
                    },
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            }

            $(document).on('click', '#add_new_line', function(e){
                e.preventDefault();
                $.ajax({
                    url: '{{route('work-order.get_row')}}',
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        $(".entry_row_div").append(response);
                        getCostAccount();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.delete_new_row', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row").remove();
                getSumAmount();
            });
        })(jQuery);
    </script>
@endpush