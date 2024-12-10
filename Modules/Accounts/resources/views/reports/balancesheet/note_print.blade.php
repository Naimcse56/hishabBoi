@extends('accounts::print_layouts.index')
@section('title')
Balance Sheet Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @if ($report_type == "fiscal_year")
                    @include('accounts::reports.balancesheet.fiscal_print_table')
                @else
                    @include('accounts::reports.balancesheet.print_table')
                @endif
            </div>
        </div>
@endsection