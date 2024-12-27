@extends('accounts::print_layouts.index')
@section('title')
Trial Balance Report Print
@endsection
@section('content')
        <div class="row">
            <div class="col-md-12">
                @include('accounts::reports.trial_balance.table')
            </div>
        </div>
@endsection