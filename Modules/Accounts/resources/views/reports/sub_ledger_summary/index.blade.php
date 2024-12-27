@extends('layouts.admin_app')
@section('title')
Party Summary Report
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Party Summary Report</h4>
            <div>
                <a href="{{route('accountings.sub_ledger_summary_report')}}" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-refresh"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-filter"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-sm btn-primary mt-4" target="_blank"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div {{isset($reports) ? 'd-none' : ''}}">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('accountings.sub_ledger_summary_report')}}">
                            <div class="row">
                                <x-common.select :required="true" column=4 name="type" class="type" label="Type" placeholder="Type" :value="'Client'" :options="[
                                ['id' => 'Client', 'name' => 'Client'],
                                ['id' => 'Vendor', 'name' => 'Vendor'],
                                ['id' => 'Staff', 'name' => 'Staff']
                                ]"></x-common.select>
                                <x-common.server-side-select :required="false" column=4 name="party_id" class="party_id" disableOptionText="Select Party Account" label="Party Accounts"></x-common.server-side-select>
                                <x-common.server-side-select :required="false" column=4 name="account_id" class="account_id" disableOptionText="Select Account" label="Select Account"></x-common.server-side-select>
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
            @isset($reports)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if (request('type') == "Client" || request('type') == "Staff")
                                @include('accounts::reports.sub_ledger_summary.customer_table')
                            @else
                                @include('accounts::reports.sub_ledger_summary.vendor_table')
                            @endif
                        </div>
                    </div>
                </div>
            @endisset
        </div>
        <div id="ajaxDiv"></div>
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
            $(document).on('click','.detail_info', function(){
                $('.detail_info').addClass('disabled');
                var url = $(this).attr("data-route");
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "HTML",
                    success: function (response) {
                        $('#ajaxDiv').html(response);
                        $('#detail_info_modal').modal('show');
                        $('.detail_info').removeClass('disabled');
                    },
                    error: function (error) {
                        $('.detail_info').removeClass('disabled');
                    }
                });
            });
            $(".party_id").select2({
                ajax: {
                    url: '{{route('sub-ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: $('#type').val(),
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            $(".account_id").select2({
                    ajax: {
                        url: '{{route('ledger.transactional_list_for_select')}}',
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