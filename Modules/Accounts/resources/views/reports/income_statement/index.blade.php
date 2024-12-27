@extends('layouts.admin_app')
@section('title')
Income Statemment Report
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Income Statement Report</h4>
            <div>
                <a href="{{route('accountings.income_statement')}}" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-refresh"></i></a>
                <a href="javascript:;" class="btn btn-sm btn-primary mt-4 filter_by"><i class="fa fa-filter"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-sm btn-primary mt-4" target="_blank"><i class="fa fa-print"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('accountings.income_statement')}}">
                            <div class="row">
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('accounts::reports.income_statement.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection