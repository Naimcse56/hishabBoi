@extends('accounts::print_layouts.index')
@section('title')
Cashbook Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @isset($transactions)
                    @include('accounts::reports.cashbook.table')
                @endisset
            </div>
        </div>
@endsection