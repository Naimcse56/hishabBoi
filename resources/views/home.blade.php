@extends('layouts.admin_app')
@section('title')
Dashboard
@endsection

@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4 black">Dashboard</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom green">
                                <div><h4 class="amount"> {{currencySymbol($closing_cash)}}</h4>
                                </div>
                                <div class="text-white">Current Cash</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom blue">
                                <div><h4 class="amount"> {{currencySymbol($closing_bank)}}</h4>
                                </div>
                                <div class="text-white">Current Bank</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom red">
                                <div><h4 class="amount"> {{currencySymbol($closing_payable)}}</h4>
                                </div>
                                <div class="text-white">Current Payable</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card card-custom pink">
                                <div><h4 class="amount"> {{currencySymbol($closing_recievable)}}</h4>
                                </div>
                                <div class="text-white">Current Recievable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
