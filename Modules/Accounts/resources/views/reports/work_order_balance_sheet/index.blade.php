@extends('layouts.admin_app')
@section('title')
Work Order Asset and Liability Statement Report
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Work Order Asset And Liability Report</h4>
            <div>
                <a href="{{route('work-orders.balance_sheet_report')}}" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-refresh"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-filter"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-sm btn-primary mt-4" target="_blank"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('work-orders.balance_sheet_report')}}">
                            <div class="row">
                                <x-common.server-side-select :required="false" column=4 name="client" class="client" disableOptionText="Select Party Account" label="Party Accounts"></x-common.server-side-select>
                                <x-common.server-side-select :required="false" column=4 name="work_order_id" class="work_order_id" disableOptionText="Select Work Order" label="Work Order"></x-common.server-side-select>
                                <x-common.server-side-select :required="false" column=4 name="work_order_site_detail_id" class="work_order_site_detail_id" disableOptionText="Select Work Order Site" label="Work Order Site"></x-common.server-side-select>
                                <x-common.date-picker label="From Date" :required="true" column=4 name="start_date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.date-picker label="To Date" :required="true" column=4 name="end_date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @isset($filtered_branch)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('accounts::reports.work_order_balance_sheet.table')
                    </div>
                </div>
            </div>
            @endisset
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.filter_by', function(e){
                if ($('.filter_div').hasClass('d-none')) {
                    $('.filter_div').removeClass('d-none')
                }else{
                    $('.filter_div').addClass('d-none')
                }
            });

            $(".client").select2({
                ajax: {
                    url: "{{route('sub-ledger.transactional_list_for_select')}}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: 'Client',
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });

            $(".work_order_id").select2({
                ajax: {
                    url: '{{route('work-order.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                sub_ledger_id: $(".client").val(),
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