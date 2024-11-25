@extends('backend.index')
@section('title')
Chart of Accounts
@endsection
@section('bodyContent')
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Accounts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('ledger.index')}}"><i class="bx bx-line-chart-down"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Chart of Account</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <a href="{{route('ledger.index')}}" class="btn btn-primary"><i class="lni lni-list"></i></a>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="journal_create_form" method="POST" enctype="multipart/form-data" action="{{route('ledger.update', encrypt($ledger->id))}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 parent_chartAccount">
                                    <label class="form-label" for="Select Parent Account">Parent Account <span class="text-danger">*</span></label>
                                    <select class="form-select debit_account_id parent_id" name="parent_id" id="parent_id" required>
                                        <option value="{{$ledger->parent_id}}" selected>{{$ledger->parent->name}}</option>
                                    </select>
                                </div>     
                                {{-- <div class="col-md-4" class="account_type" id="account_type">
                                    <label class="form-label" for="">Account Type <span class="text-danger">*</span></label>
                                    <select class="form-select main_select_2 a_type" name="type" id="type" required>
                                        <option value="1" @selected($ledger->type == 1)>Asset</option>
                                        <option value="2" @selected($ledger->type == 2)>Liability</option>
                                        <option value="3" @selected($ledger->type == 3)>Expense</option>
                                        <option value="4" @selected($ledger->type == 4)>Income</option>
                                        <option value="5" @selected($ledger->type == 5)>Equity</option>
                                    </select>
                                    <span class="text-danger" id="type_error"></span>
                                </div> --}}
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Account Head <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Account Head / Ledger" value="{{$ledger->name}}" required>
                                    <span class="text-danger" id="name_error">{{$errors->first('name')}}</span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="code">Account Code <span class="text-danger">*</span></label>
                                    <input id="code" name="code" class="form-control" placeholder="Account Code" type="text" value="{{$ledger->code}}" required>
                                    <small class="text-danger" id="code_error">{{$errors->first('code')}}</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label mt-3" for="">Accessable From All Branches <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="us_as_global" value="1" @checked($ledger->branch_id == 0)>
                                            <label class="form-check-label" for="us_as_global">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="us_as_global" value="0" @checked($ledger->branch_id > 0)>
                                            <label class="form-check-label" for="us_as_global">No</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_active_error"></span>
                                </div>
        
                                {{-- <div class="col-md-4">
                                    <label class="form-label mt-3" for="Is Cost Center">Is Cost Center <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_cost_center" value="1" @checked($ledger->is_cost_center == 1)>
                                            <label class="form-check-label" for="is_cost_center">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_cost_center" value="0" @checked($ledger->is_cost_center == 0)>
                                            <label class="form-check-label" for="is_cost_center">No</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_group_error"></span>
                                </div> --}}
        
                                <div class="col-md-4">
                                    <label class="form-label mt-3" for="Is Cost Center">Cash Flow <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input cashFlow" type="radio" name="cash_flow" value="operating" @checked($ledger->cash_flow == "operating")>
                                            <label class="form-check-label" for="cashFlow">Operating</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input cashFlow" type="radio" name="cash_flow" value="investing" @checked($ledger->cash_flow == "investing")>
                                            <label class="form-check-label" for="cashFlow">Investing</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input cashFlow" type="radio" name="cash_flow" value="financing" @checked($ledger->cash_flow == "financing")>
                                            <label class="form-check-label" for="cashFlow">Financing</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_group_error"></span>
                                </div>
        
                                <div class="col-md-4" id="acc_type_div">
                                    <label class="form-label mt-3" for="Ledger Type">Ledger Type <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc_type" type="radio" name="acc_type" value="others" @checked($ledger->acc_type == "others")>
                                            <label class="form-check-label" for="account_type">Others</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc_type" type="radio" name="acc_type" value="cash" @checked($ledger->acc_type == "cash")>
                                            <label class="form-check-label" for="account_type">Cash</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc_type" type="radio" name="acc_type" value="bank" @checked($ledger->acc_type == "bank")>
                                            <label class="form-check-label" for="account_type">Bank</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="acc_type_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label mt-3" for="">Status <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" value="1" @checked($ledger->is_active == 1)>
                                            <label class="form-check-label" for="is_active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_active" value="0" @checked($ledger->is_active == 0)>
                                            <label class="form-check-label" for="is_active">Inactive</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_active_error"></span>
                                </div>
                            </div>
                            <div class="row ac_no_div {{$ledger->acc_type == "bank" ? '' : 'd-none'}}">
                                <div class="col-md-12 general_config_div">
                                    <fieldset class="the-fieldset mt-2">
                                        <legend class="the-legend">Bank Information</legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="bank_ac_name">Bank Account Name</label>
                                                <input id="bank_ac_name" name="bank_ac_name" class="form-control" placeholder="Account Name" type="text" value="{{$ledger->bank_ac_name}}">
                                                <span class="text-danger" id="bank_ac_name_error"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="ac_no">Bank Account No</label>
                                                <input id="ac_no" name="ac_no" class="form-control" placeholder="Account Code" type="text" value="{{$ledger->ac_no}}">
                                                <span class="text-danger" id="ac_no_error"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="routing_no">Routing No</label>
                                                <input id="routing_no" name="routing_no" class="form-control" placeholder="Routing No" type="text" value="{{$ledger->routing_no}}">
                                                <span class="text-danger" id="routing_no_error"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="swift_code">Swift Code</label>
                                                <input id="swift_code" name="swift_code" class="form-control" placeholder="Swift Code" type="text" value="{{$ledger->swift_code}}">
                                                <span class="text-danger" id="swift_code_error"></span>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <label class="form-label" for="branch_code">Branch Code</label>
                                                <input id="branch_code" name="branch_code" class="form-control" placeholder="Branch Code" type="text" value="{{$ledger->branch_code}}">
                                                <span class="text-danger" id="branch_code_error"></span>
                                            </div>
                                            <div class="col-md-8 mt-2">
                                                <label class="form-label" for="bank_address">Bank Address</label>
                                                <input id="bank_address" name="bank_address" class="form-control" placeholder="Bank Address" type="text" value="{{$ledger->bank_address}}">
                                                <span class="text-danger" id="bank_address_error"></span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <input type="hidden" name="s_id" id="s_id" value="{{$ledger->id}}">
                            <input type="hidden" name="row_count" id="row_count" value="1">
                            <input type="hidden" name="class_name" id="class_name" value="0">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label mt-3" for="">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Description ..." rows="3">{{$ledger->description}}</textarea>
                                    <span class="text-danger" id="description_error"></span>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-12 general_config_div">
                                    <fieldset class="the-fieldset mt-5">
                                        <legend class="the-legend">Balance Sheet & Income Statement Configuration</legend>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label" for="">Display in Balance Sheet <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_bs" value="1" @checked($ledger->view_in_bs == 1)>
                                                        <label class="form-check-label" for="view_in_bs">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_bs" value="0" @checked($ledger->view_in_bs == 0)>
                                                        <label class="form-check-label" for="view_in_bs">No</label>
                                                    </div>
                                                </div>
                                                <span class="text-danger" id="is_active_error">{{$errors->first('view_in_bs')}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="">Display in Income Statement <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_is" value="1" @checked($ledger->view_in_is == 1)>
                                                        <label class="form-check-label" for="view_in_is">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_is" value="0" @checked($ledger->view_in_is == 0)>
                                                        <label class="form-check-label" for="view_in_is">No</label>
                                                    </div>
                                                </div>
                                                <span class="text-danger" id="is_active_error">{{$errors->first('view_in_is')}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="">Display in Trial Balance <span class="text-danger">*</span></label>
                                                <div class="">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_trial" value="1" @checked($ledger->view_in_trial == 1)>
                                                        <label class="form-check-label" for="view_in_trial">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="view_in_trial" value="0" @checked($ledger->view_in_trial == 0)>
                                                        <label class="form-check-label" for="view_in_trial">No</label>
                                                    </div>
                                                </div>
                                                <span class="text-danger" id="is_active_error">{{$errors->first('view_in_trial')}}</span>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                {{-- <div class="col-md-12 report_config_div">
                                    <fieldset class="the-fieldset mt-3">
                                        <legend class="the-legend">Income Statement Report Configuration</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label d-block" for="">Use this Account as</label>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="direct_income_leadger" @checked($ledger->config == "direct_income_leadger")>
                                                    <label class="form-check-label" for="report_config">Direct Income Head</label>
                                                </div>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="in_direct_income_leadger" @checked($ledger->config == "in_direct_income_leadger")>
                                                    <label class="form-check-label" for="report_config">Indirect Income Head</label>
                                                </div>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="others_income_leadger">
                                                    <label class="form-check-label" for="report_config">Others Income Head</label>
                                                </div>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="direct_expense_leadger" @checked($ledger->config == "direct_expense_leadger")>
                                                    <label class="form-check-label" for="report_config">Indirect Expense Head</label>
                                                </div>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="in_direct_expense_leadger" @checked($ledger->config == "in_direct_expense_leadger")>
                                                    <label class="form-check-label" for="report_config">Indirect Expense Head</label>
                                                </div>
                                                <div class="form-check form-check-inline cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="others_expense_leadger">
                                                    <label class="form-check-label" for="report_config">Other Expense Head</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="company_income_tax" @checked($ledger->config == "company_income_tax")>
                                                    <label class="form-check-label" for="report_config">Company Income Tax (Expense)</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="income_summary_debit_leadger" @checked($ledger->config == "income_summary_debit_leadger")>
                                                    <label class="form-check-label" for="report_config">Income Summary Debit Ledger (Expense)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div> --}}
                                
                                {{-- <div class="col-md-12 report_config_div">
                                    <fieldset class="the-fieldset mt-3">
                                        <legend class="the-legend">Balance Sheet Report Configuration</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="retail_earning_leadger" @checked($ledger->config == "retail_earning_leadger")>
                                                    <label class="form-check-label" for="report_config">Retail Earning Ledger (Liability)</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="report_config" value="company_tax_leadger" @checked($ledger->config == "company_tax_leadger")>
                                                    <label class="form-check-label" for="report_config">Company Tax Payable (Liability)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div> --}}
                                
                                {{-- <div class="col-md-12 general_config_div">
                                    <fieldset class="the-fieldset mt-5">
                                        <legend class="the-legend">Party Account Head Configuration</legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="general_config" value="account_payable" @checked($ledger->config == "account_payable")>
                                                    <label class="form-check-label" for="general_config">Supplier Head Account</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="general_config" value="account_recievable" @checked($ledger->config == "account_recievable")>
                                                    <label class="form-check-label" for="general_config">Customer Head Account</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="general_config" value="leadger_account_for_employee" @checked($ledger->config == "leadger_account_for_employee")>
                                                    <label class="form-check-label" for="general_config">Member Head Account</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="general_config" value="default_sales_account" @checked($ledger->config == "default_sales_account")>
                                                    <label class="form-check-label" for="general_config">Default Sales Account</label>
                                                </div>
                                                <div class="form-check form-check-inline non_cost_center_div">
                                                    <input class="form-check-input" type="radio" name="general_config" value="default_purchases_account" @checked($ledger->config == "default_purchases_account")>
                                                    <label class="form-check-label" for="general_config">Default Purchase Account</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary save-btn "><i class="bx bx-check-double"></i>Save</button>
                                </div>
                            </div>
                        </form>
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let selected_parent_id = $('#selected_parent_id').val();
                parentChartAccountEdit(null, selected_parent_id, null);
            });

            $(document).on('change', '#parent_id', function(e) {
                generateCode($('#parent_id').val());
            });
            
            $(".debit_account_id").select2({
                ajax: {
                    url: '{{route('ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                branch_id: $(".branch_id").val(),
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

            function generateCode(parent_id) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('ledger.code_checker') }}",
                    data: {
                        parent_id: parent_id,
                        s_id: $('#s_id').val(),
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        if (typeof result.generated_code !== "undefined") {
                            $("#code").val(result.generated_code);
                        }else{
                            alert('Oops! Reload your browser please!')
                        }
                    }
                });
            }

            $(document).on('keyup', '#name', function(e) {
                if ($(this).val().length >= 3 && (e.keyCode != 40 || e.keyCode === 38)) {
                    var name = $(this).val();
                    $.ajax({
                        method: "POST",
                        url: "{{ route('ledger.code_checker') }}",
                        data: {
                            code: name,
                            purpose: "name",
                            _token: APP_TOKEN,
                        },
                        success: function(result) {
                            if (typeof result.message !== "undefined") {
                                $("#name_error").removeClass('text-success').addClass('text-danger mt-4').text(result.message);
                            }else{
                                $("#name_error").removeClass('text-danger').addClass('text-success').text("");
                            }
                        }
                    });
                }
            });

            $(document).on('keyup', '#code', function(e) {
                if ($(this).val().length >= 2 && (e.keyCode != 40 || e.keyCode === 38)) {
                    codeCheck($(this).val());
                }
            });
            function codeCheck(params) {
                let code = params;
                $.ajax({
                    method: "POST",
                    url: "{{ route('ledger.code_checker') }}",
                    data: {
                        code: code,
                        _token: APP_TOKEN,
                    },
                    success: function(result) {
                        console.log(typeof result.message === "undefined");
                        if (typeof result.message !== "undefined") {
                            $("#code_error").removeClass('text-success').addClass('text-danger').text(result.message);
                        }else{
                            $("#code_error").removeClass('text-danger').addClass('text-success').text("");
                        }
                    }
                });
            }

            $(document).on('click', '.as_sub_category', function () {
                $(".parent_chartAccountEdit").toggle();
            });

            $(document).on('click', '.acc_type', function(e){
                if ($(this).val() == "bank") {
                    $('.ac_no_div').removeClass('d-none')
                } else {
                    $('.ac_no_div').addClass('d-none')
                }
            });

            function parentChartAccountEdit(type = null, selected = null, editItem = null) {
                var accoutList = null;
                $.ajax({
                    url: APP_URL + "/accountings/ledger-list-cost-center",
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        if (type) {
                            accoutList = response.filter(item => item.type == editItem)
                            $("#" + type).html("");
                        } else {
                            accoutList = response;
                            $("#parent_chart_account_list_edit").html("");
                        }
                        let parent_chartAccount = '';
                        parent_chartAccount += `<select name="parent_id" class="form-select main_select_2 mb-15 parent_chart_account_list_edit mt-2">`;
                        $.each(accoutList, function (key, item) {
                            if (selected && selected == item.id) {
                                parent_chartAccount += `<option selected value="${item.id}">${item.name}</option>`;
                            } else {
                                parent_chartAccount += `<option value="${item.id}">${item.name}</option>`;
                            }
                        });
                        parent_chartAccount += `<select>`;
                        if (type) {
                            $("#" + type).html(parent_chartAccount);
                        } else {
                            $("#parent_chart_account_list_edit").html(parent_chartAccount);
                        }
                        $(".main_select_2").select2();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

        })(jQuery);
    </script>
@endpush