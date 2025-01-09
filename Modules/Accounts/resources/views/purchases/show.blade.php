@extends('layouts.admin_app')
@section('title')
Purchase Details
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Purchase Details</h4></div>
        <div>
            <a href="{{route('purchases.print',encrypt($purchase->id))}}" class="btn btn-sm btn-secondary mt-4"><i class="fa fa-print"></i> Print & Download</a>
            <a href="{{route('purchases.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a>
            @if ($purchase->is_approved != "Approved")
                <button type="button" onclick="approveData('Purchase Approval', '{{ route('purchases.approve_status') }}', {{ $purchase->id }})" class="btn btn-sm btn-success mt-4">
                    <i class="fa fa-thumbs-up"></i> APPROVE
                </button>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered border border-secondary mb-20">
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
                                    <div class="col text-center fw-semibold text-3 text-uppercase">Purchase Invoice</div>
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
                                                <td class="col-4"><strong>Product</strong></td>
                                                <td class="text-center"><strong>QTY</strong></td>
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
                                                    <td class="col-4">{{$item->product->name}}</td>
                                                    <td class="text-center">{{$item->quantity}} <small>{{$item->product->product_unit->name}}</small></td>
                                                    <td class="text-center">{{$item->tax}}</td>
                                                    <td class="text-center">{{$item->discount}}</td>
                                                    <td class="text-end nowrap">{{currencySymbol($item->per_price)}}</td>
                                                    <td class="text-end nowrap">{{currencySymbol($item->total_price)}}</td>
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
                    @foreach ($purchase->refers as $voucher)
                        @php
                            $total_debit = 0;
                            $total_credit = 0;
                        @endphp
                        <table class="table table-bordered border border-secondary mb-2">
                            <thead>
                                <tr>
                                    <td colspan="4"><strong>Details : {{$voucher->TypeName}}</strong></td>
                                </tr>
                                <tr class="bg-light">
                                    <td><strong>Ledger</strong></td>
                                    <td><strong>Party</strong></td>
                                    <td><strong>Narration</strong></td>
                                    <td class="col-2 text-end"><strong>Debit</strong></td>
                                    <td class="col-2 text-end"><strong>Credit</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voucher->transactions as $item)
                                    @php
                                        if ($item->type == "Dr") {
                                            $total_debit += $item->amount;
                                        } else {
                                            $total_credit += $item->amount;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $item->ledger->name }} ({{ $item->ledger->code }})</a></td>
                                        <td>
                                            {{ $item->sub_ledger->name }}
                                            @if ($item->work_order_id)
                                            <p class="mb-0 font-13">Client : {{ $item->work_order->sub_ledger->name }}</p>
                                            <p class="mb-0 font-13">Work Order : {{ $item->work_order->order_name }}</p>
                                            <p class="mb-0 font-13">Work Order No : {{ $item->work_order->order_no }}</p>
                                            <p class="mb-0 font-13">Work Order Site : {{ $item->work_order_site_detail->site_name }}</p>
                                            @endif
                                            @if ($item->check_no || $item->bank_name || $item->bank_account_name)
                                                <p class="mb-0 font-13">Bank Name : {{$item->bank_name}}</p>
                                                <p class="mb-0 font-13">Bank Account Name : {{$item->bank_account_name}}</p>
                                                <p class="mb-0 font-13">Cheque No : {{$item->check_no}}</p>
                                                <p class="mb-0 font-13">Cheque Maturity Date : {{$item->check_mature_date}}</p>
                                            @endif
                                        </td>
                                        <td>{{$item->narration}}</td>
                                        <td class="nowrap text-end">
                                            {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                                        </td>
                                        <td class="nowrap text-end">
                                            {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Total Amount</td>
                                    <td class="nowrap text-end" id="total_debit"> {{ number_format($total_debit, 2) }}</td>
                                    <td class="nowrap text-end" id="total_credit"> {{ number_format($total_credit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>In Words: </td>
                                    <td colspan="4">{{convert_number($voucher->amount)}} Only</td>
                                </tr>
                            </tbody>
                        </table>                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection