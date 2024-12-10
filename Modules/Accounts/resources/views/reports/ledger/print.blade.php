@extends('accounts::print_layouts.index')
@section('title')
Ledger Report Print
@endsection
@section('content')
        @isset($transactions)
            <div class="row">
                <div class="col-md-12">
                    @if ($filtered_account->type == 1 || $filtered_account->type == 3)
                        @include('accounts::reports.ledger.debit_table')
                    @else
                        @include('accounts::reports.ledger.credit_table')
                    @endif
                </div>
            </div>
        @endisset
@endsection