@extends('accounts::print_layouts.index')
@section('title')
Receipt And Payment Report Print
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('accounts::reports.work_order_receive_payment_report.table')
        </div>
    </div>
@endsection