@extends('accounts::print_layouts.index')
@section('title')
Income Statement Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.income_statement.table')
            </div>
        </div>
@endsection