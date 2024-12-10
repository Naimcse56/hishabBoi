@extends('accounts::print_layouts.index')
@section('title')
Work Order Asset and Liability Statement Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.work_order_balance_sheet.print_table')
            </div>
        </div>
@endsection