@extends('accounts::print_layouts.index')
@section('title')
Work Order Profit Loss Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.work_order_profit_loss.table')
            </div>
        </div>
@endsection