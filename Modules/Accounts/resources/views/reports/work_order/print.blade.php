@extends('accounts::print_layouts.index')
@section('title')
Work Order Print
@endsection
@section('content')
        @isset($work_order)
            <div class="row">
                <div class="col-md-12">
                    @include('accounts::reports.work_order.debit_table')
                </div>
            </div>
        @endisset
@endsection