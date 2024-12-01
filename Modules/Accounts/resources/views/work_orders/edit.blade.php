@extends('layouts.admin_app')
@section('title')
Work Order
@endsection
@section('content')=
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
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" for="Head Account">Client <span class="text-danger">*</span></label>
                                    <select class="form-select account_id" name="sub_ledger_id" required>
                                        <option value="{{$item->sub_ledger_id}}">{{$item->sub_ledger->name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="Work Order Name" class="form-label mt-2">Work Order Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="order_name" name="order_name" placeholder="Work Order Name" value="{{$item->order_name}}" required>
                                    <span class="text-danger" id="order_name_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mt-2" for="Work Order No">Work Order No. <span class="text-danger">*</span></label>
                                    <input id="order_no" name="order_no" class="form-control" placeholder="Work Order No" type="text" value="{{$item->order_no}}" required>
                                    <span class="text-danger" id="order_no_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mt-2" for="Work Order Value">Work Order Value <span class="text-danger">*</span></label>
                                    <input id="order_value" name="order_value" class="form-control" placeholder="Work Order Value" type="number" step="0.01" min="0" value="{{$item->order_value}}" required>
                                    <span class="text-danger" id="order_value_error"></span>
                                </div>
                                {{-- <div class="col-md-6 mb-2">
                                    <label class="form-label mt-2" for="Cost Amount">Cost Amount <span class="text-danger">*</span></label>
                                    <input id="cost_amount" name="cost_amount" class="form-control" placeholder="Cost Amount" type="number" step="0.01" min="0" value="{{$item->cost_amount}}" required>
                                    <span class="text-danger" id="cost_amount_error"></span>
                                </div> --}}
                                <div class="col-md-6 mb-2">
                                    <label for="Awarded By" class="form-label">Awarded By</label>
                                    <input type="text" class="form-control" id="awarded_by" name="awarded_by" value="{{$item->awarded_by}}" placeholder="Awarded By">
                                    <span class="text-danger" id="awarded_by_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks ..." rows="3">{{$item->remarks}}</textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Work Order Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="create_date" id="date" value="{{ date('d/m/Y', strtotime($item->date)) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Work Order Close Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="end_date" id="end_date" value="{{ date('d/m/Y', strtotime($item->final_date)) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label mt-2" for="">Status</label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" value="1" @checked($item->is_active == 1)>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" value="0" @checked($item->is_active == 0)>
                                            <label class="form-check-label" for="is_active">Inactive</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_active_error"></span>
                                </div>
                            </div>
                            
                            <fieldset class="the-fieldset mt-4">
                                <legend class="the-legend">Estimation Cost Information</legend>
                                <div class="entry_row_div">
                                    @foreach ($item->work_order_estimation_costs as $estimation_cost)
                                        <div class="row new_added_row">
                                            <div class="col-md-8 mb-3">
                                                <label class="form-label" for="Cost Type">Cost Type <span class="text-danger">*</span></label>
                                                <select class="form-select cost_account_id" name="cost_type[]" required>
                                                    <option value="{{$estimation_cost->ledger_id}}">{{$estimation_cost->ledger->name}}</option>
                                                </select>
                                                <span class="text-danger">{{$errors->first('credit_account_id')}}</span>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="Cost Amount" class="form-label">Cost Amount</label>
                                                <input type="number" min="0" step="0.001" class="form-control" name="cost_amounts[]" placeholder="0.00" value="{{$estimation_cost->estimated_amount}}">
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <div class="d-block">
                                                    <label class="form-label" for=""> Action </label>
                                                    <div>
                                                        <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="bx bx-trash"></i></a>
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
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-check-double"></i>Save</button>
                                </div>
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
                                    branch_id: $(".branch_id").val()
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
                                    branch_id: $(".branch_id").val()
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