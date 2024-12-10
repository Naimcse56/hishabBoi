@extends('layouts.admin_app')
@section('title')
Balance Sheet Report
@endsection
@push('styles')
    <style>
    .fs-14{
        font-size: 14px !important;
    }
    </style>
@endpush
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Balance Sheet Report</h4>
            <div>
                <a href="{{route('accountings.balancesheet')}}" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-refresh"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-filter"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-sm btn-primary mt-4" target="_blank"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div {{isset($filtered_branch) ? 'd-none' : ''}}">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('accountings.balancesheet')}}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label mt-3" for="">Report Type <span class="text-danger">*</span></label>
                                    <div class="">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input report_type" type="radio" name="report_type" value="date_range" >
                                            <label class="form-check-label" for="report_type">Date Range</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input report_type" type="radio" name="report_type" value="fiscal_year" checked>
                                            <label class="form-check-label" for="report_type">Fiscal Year</label>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="is_active_error"></span>
                                </div>
                                <div class="col-md-3 mb-3 fiscal_report">
                                    <label class="form-label" for="">Fiscal Year</label>
                                    <select class="form-select main_select_2" name="year" id="year" required>
                                        @foreach ($fiscal_years as $fiscal_year)
                                            <option value="{{$fiscal_year->id}}" @selected(request('year') == $fiscal_year->id)>{{$fiscal_year->year}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="branch_id_error"></span>
                                </div>
                                <div class="col-md-3 mb-3 fiscal_report">
                                    <label class="form-label" for="">Comparative Fiscal Year</label>
                                    <select class="form-select main_select_2 prev_year" name="prev_year" id="prev_year" required>
                                        @foreach ($fiscal_years as $fiscal_year)
                                            <option value="{{$fiscal_year->id}}" @selected(request('prev_year') == $fiscal_year->id)>{{$fiscal_year->year}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="branch_id_error"></span>
                                </div>
                                <div class="col-md-3 mb-3 non_fiscal_report d-none">
                                    <label class="form-label">From Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="start_date" id="start_date" value="{{date('d/m/Y', strtotime(app('day_closing_info')->from_date))}}">
                                </div>
                                <div class="col-md-3 mb-3 non_fiscal_report d-none">
                                    <label class="form-label">To Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="end_date" id="end_date" value="{{date('d/m/Y')}}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i>Search</button>
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
                            @if ($report_type == "fiscal_year")
                                @include('accounts::reports.balancesheet.fiscal_table')
                            @else
                                @include('accounts::reports.balancesheet.table')
                            @endif
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
            $(document).on('click', '.report_type', function(e){
                if ($(this).val() == "date_range") {
                    $('.non_fiscal_report').removeClass('d-none')
                    $('.fiscal_report').addClass('d-none')
                } else {
                    $('.non_fiscal_report').addClass('d-none')
                    $('.fiscal_report').removeClass('d-none')
                }
            });
        })(jQuery);
    </script>
@endpush