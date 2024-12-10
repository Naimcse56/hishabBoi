@extends('layouts.admin_app')
@section('title')
Receipt And Payment Report
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Receipt And Payment Report</h4>
            <div>
                <a href="{{route('accountings.receive_payment_report')}}" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-refresh"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-filter"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-sm btn-primary mt-4" target="_blank"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div {{isset($filtered_branch) ? 'd-none' : ''}}">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('accountings.receive_payment_report')}}">
                            <div class="row">
                                <x-common.date-picker label="From Date" :required="true" column=6 name="start_date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
                                <x-common.date-picker label="To Date" :required="true" column=6 name="end_date" placeholder="Date" :value="date('d/m/Y', strtotime(app('day_closing_info')->from_date))" placeholder="dd/mm/yyyy" ></x-common.date-picker>
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
                        <div class="row">
                            <div class="col-md-12">
                                @include('accounts::reports.receive_payment_report.table')
                            </div>
                        </div>
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
        })(jQuery);
    </script>
@endpush