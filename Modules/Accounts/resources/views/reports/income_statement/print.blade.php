@extends('accounts::print_layouts.index')
@section('title')
Income Statement Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @if ($report_type == "fiscal_year")
                    @include('accounts::reports.income_statement.fiscal_table')
                @else
                    @include('accounts::reports.income_statement.table')
                @endif
            </div>
        </div>
@endsection