@extends('layouts.invoice')
@section('title')
{{$purchase->invoice_no}} Print
@endsection
@section('content')
<div class="container-fluid invoice-container">
    <table class="table table-bordered border border-secondary mb-0">
        <tbody>
            <tr>
            <td colspan="2" class="bg-light text-center"><h3 class="mb-0">{{ app('general_setting')['company_name'] }}</h3></td>
            </tr>
            <tr>
            <td colspan="2" class="text-center text-uppercase">{{ app('general_setting')['company_address'] }}</td>
            </tr>
            <tr>
            <td colspan="2" class="py-1">
                <div class="row">
                    <div class="col">Memo</div>
                    <div class="col text-center fw-semibold text-3 text-uppercase">Sale Invoice</div>
                    <div class="col text-end">Original</div>
                </div>
            </td>
            </tr>
            <tr>
            <td class="col-7">
                <div class="row gx-2 gy-2">
                    <div class="col-auto"><strong>M/s. :</strong></div>
                    <div class="col">
                        <address>
                            <strong>{{$purchase->sub_ledger->name}}</strong><br/>
                            {{$purchase->phone}}<br/>
                        </address>
                    </div>
                </div>
            </td>
            <td class="col-5 bg-light">
                <div class="row gx-2 gy-1 fw-semibold">
                    <div class="col-5">Date <span class="float-end">:</span></div>
                    <div class="col-7">{{showDateFormat($purchase->date)}}</div>
                    <div class="col-5">Invoice No <span class="float-end">:</span></div>
                    <div class="col-7">{{$purchase->invoice_no}}</div>
                    <div class="col-5">Ref No <span class="float-end">:</span></div>
                    <div class="col-7">{{$purchase->ref_no}}</div>
                    <div class="col-5">Credit Period <span class="float-end">:</span></div>
                    <div class="col-7">{{$purchase->credit_period}} Days</div>
                </div>
            </td>
            </tr>
            <tr>
                <td colspan="2" class="p-0">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr class="bg-light">
                                <td class="text-center" width="3%"><strong>#</strong></td>
                                <td class="col-6"><strong>Product</strong></td>
                                <td class="text-center"><strong>Qty</strong></td>
                                <td class="text-center"><strong>Tax (%)</strong></td>
                                <td class="text-center"><strong>Dis (%)</strong></td>
                                <td class="col-2 text-end"><strong>Rate</strong></td>
                                <td class="col-2 text-end"><strong>Total</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->purchase_details as $key => $item)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="col-6">{{$item->product->name}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">{{$item->tax}}</td>
                                    <td class="text-center">{{$item->discount}}</td>
                                    <td class="text-end">{{currencySymbol($item->per_price)}}</td>
                                    <td class="text-end">{{currencySymbol($item->total_price)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="bg-light fw-semibold">
                <td class="col-7 py-1">
                    <span class="fw-semibold">Paid Amount:</span> <i>{{currencySymbol($purchase->morphs()->sum('amount'))}}</i>
                </td>
                <td class="col-5 py-1 pe-1">Sub Total: <span class="float-end">{{currencySymbol($purchase->total_amount)}}</span></td>
            </tr>
            <tr>
                <td class="col-7 text-1"><span class="fw-semibold">Bill Amount:</span> <i>{{convert_number($purchase->payable_amount)}}</i></td>
                <td class="col-5 pe-1">
                Discount: <span class="float-end">{{currencySymbol($purchase->discount_amount)}}</span>
                </td>
            </tr>
            <tr>
                <td class="col-7 text-1">Note : {{$purchase->note}}</td>
                <td class="col-5 pe-1 bg-light fw-semibold">
                    Grand Total:<span class="float-end">{{currencySymbol($purchase->payable_amount)}}</span>
                </td>
            </tr>
            <tr>
                <td class="col-7 text-1">
                    <div class="fw-semibold">Terms & Condition :</div>
                    <div class="fw-semibold">{!!$purchase->terms_condition!!}</div>
                </td>
                <td class="col-5 pe-1 text-end">
                    For, {{ app('general_setting')['company_name'] }}
                    <div class="text-1 fst-italic mt-5">(Authorised Signatory)</div>
                </td>
            </tr>
        </tbody>
    </table>
    <footer class="text-center mt-4">
      <div class="btn-group btn-group-sm d-print-none"> <a href="{{route('purchases.index')}}" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-list"></i> Back To List</a> </div>
      <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print & Download</a> </div>
    </footer>
</div>
@endsection