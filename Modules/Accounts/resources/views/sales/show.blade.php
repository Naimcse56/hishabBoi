@extends('layouts.admin_app')
@section('title')
Sale Details
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Sale Details</h4></div>
        <div><a href="{{route('sales.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-container">
                        <div class="float-start">
                            <img src="{{ asset(app('general_setting')['company_logo']) }}" width="205px"  alt="invoice" />
                        </div>
                        <div class="float-end datetime">
                            INVOICE ID:{{$sale->invoice_no}}
                            <br>
                            {{$sale->date}}
                        </div>
                        <div class="d-block">
                            <div class="float-start">
                                <span class="orange">WELCOME TO:</span> <br>
                                {{$sale->sub_ledger->name}}<br> {{$sale->phone ? $sale->phone : $sale->sub_ledger->code}}
                            </div>
                            {{-- <div class="float-end datetime">
                                <span class="orange">PAYMENT METHOD</span>
                                <br>
                                Account NO: 102012012<br>
                                Account Name: Monir
                            </div> --}}
                        </div>
                        <div class="mt30">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Tax (%)</th>
                                    <th scope="col">Dis (%)</th>
                                    <th scope="col" class="text-right">Price</th>
                                    <th scope="col" class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->sale_details as $key => $item)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>{{$item->product->name}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->tax}}</td>
                                            <td>{{$item->discount}}</td>
                                            <td class="text-right">{{number_format($item->per_price, 2)}}</td>
                                            <td class="text-right">{{number_format($item->total_price, 2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-right">Total Amount</td>
                                        <td class="text-right">{{number_format($sale->total_amount, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-right">Discount</td>
                                        <td class="text-right">{{number_format($sale->discount_amount, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-right">Net Amount</td>
                                        <td class="text-right">{{number_format($sale->payable_amount, 2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Notes</h6>
                                <h6>{{$sale->note}}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6>Terms & Condition</h6>
                                <h6>Bootstrap's tables are opt-in. Add the base class .table to anBootstrap's tables are opt-in. Add the base class .table to an</h6>
                            </div>
                        </div>
                        <div class="mt30">
                            <span class="float-start">
                                {{$sale->creator->name}}
                                <hr>
                            </span>
                            <span class="float-end">
                                Authorised Signature   
                                <hr>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;

        })(jQuery);
    </script>
@endpush