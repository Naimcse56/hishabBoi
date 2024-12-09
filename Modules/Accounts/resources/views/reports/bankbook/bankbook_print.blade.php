@extends('accounts::print_layouts.index')
@section('title')
Bank Book Print
@endsection
@section('bodyContent')
    @isset($transactions)
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.bankbook.table')
            </div>
        </div>
    @endisset
@endsection