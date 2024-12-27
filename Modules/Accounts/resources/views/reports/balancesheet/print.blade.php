@extends('accounts::print_layouts.index')
@section('title')
BalanceSheet Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.balancesheet.table')
            </div>
        </div>
@endsection