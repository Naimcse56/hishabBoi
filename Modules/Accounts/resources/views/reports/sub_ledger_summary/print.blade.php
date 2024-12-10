@extends('accounts::print_layouts.index')
@section('title')
Party Summary Print
@endsection
@section('content')
        @isset($reports)
            <div class="row">
                <div class="col-md-12">
                    @if (request('type') == "Client" || request('type') == "Staff")
                        @include('accounts::reports.sub_ledger_summary.customer_table')
                    @else
                        @include('accounts::reports.sub_ledger_summary.vendor_table')
                    @endif
                </div>
            </div>
        @endisset
@endsection