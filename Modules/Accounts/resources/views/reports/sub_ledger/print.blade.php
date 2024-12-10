@extends('accounts::print_layouts.index')
@section('title')
Party Account Print
@endsection
@section('content')
        @isset($transactions)
            <div class="row">
                <div class="col-md-12">
                    @php
                        $account_type = $filtered_account->ledger->type;
                    @endphp
                    @if ($account_type == 1 || $account_type == 3)
                        @include('accounts::reports.sub_ledger.debit_table')
                    @else
                        @include('accounts::reports.sub_ledger.credit_table')
                    @endif
                </div>
            </div>
        @endisset
@endsection