@extends('accounts::print_layouts.index')
@section('title')
Ledger Details Print
@endsection
@section('bodyContent')
        <div class="row">
            <div class="col-md-12">
                @isset($transactions)
                    @include('accounts::reports.ledger_details.table')
                @endisset
            </div>
        </div>
@endsection