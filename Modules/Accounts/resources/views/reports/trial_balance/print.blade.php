@extends('accounts::print_layouts.index')
@section('title')
Trial Balance Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @if ($report_type == "fiscal_year")
                    @include('accounts::reports.trial_balance.fiscal_table')
                @else
                    @include('accounts::reports.trial_balance.table')
                @endif
            </div>
        </div>
@endsection