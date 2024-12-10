@extends('accounts::print_layouts.index')
@section('title')
Work Order Summary Print
@endsection
@section('content')
        @isset($reports)
            <div class="row">
                <div class="col-md-12">
                    @include('accounts::reports.work_order_summary.debit_table')
                </div>
            </div>
        @endisset
@endsection