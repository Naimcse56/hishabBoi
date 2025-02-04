@extends('layouts.admin_app')
@section('title')
Quotation Details
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Quotation Details</h4></div>
        <div>
            <a href="{{route('quotations.print',encrypt($quotation->id))}}" class="btn btn-sm btn-secondary mt-4"><i class="fa fa-print"></i> Print & Download</a>
            <a href="{{route('quotations.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a>
            @if ($quotation->is_approved != "Approved")
                <button type="button" onclick="approveData('Quotation Approval', '{{ route('quotations.approve_status') }}', {{ $quotation->id }})" class="btn btn-sm btn-success mt-4">
                    <i class="fa fa-thumbs-up"></i> APPROVE
                </button>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
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
                                            <strong>{{$quotation->sub_ledger->name}}</strong><br/>
                                            {{$quotation->phone}}<br/>
                                        </address>
                                    </div>
                                </div>
                            </td>
                            <td class="col-5 bg-light">
                                <div class="row gx-2 gy-1 fw-semibold">
                                    <div class="col-5">Date <span class="float-end">:</span></div>
                                    <div class="col-7">{{showDateFormat($quotation->date)}}</div>
                                    <div class="col-5">Invoice No <span class="float-end">:</span></div>
                                    <div class="col-7">{{$quotation->invoice_no}}</div>
                                    <div class="col-5">Ref No <span class="float-end">:</span></div>
                                    <div class="col-7">{{$quotation->ref_no}}</div>
                                    <div class="col-5">Credit Period <span class="float-end">:</span></div>
                                    <div class="col-7">{{$quotation->credit_period}} Days</div>
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
                                                <td class="text-center"><strong>Qty</strong></td>
                                                <td class="text-center"><strong>Tax (%)</strong></td>
                                                <td class="text-center"><strong>Dis (%)</strong></td>
                                                <td class="col-2 text-end"><strong>Rate</strong></td>
                                                <td class="col-2 text-end"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quotation->quotation_details as $key => $item)
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
                                    
                                </td>
                                <td class="col-5 py-1 pe-1">Sub Total: <span class="float-end">{{currencySymbol($quotation->total_amount)}}</span></td>
                            </tr>
                            <tr>
                                <td class="col-7 text-1"><span class="fw-semibold">Bill Amount:</span> <i>{{convert_number($quotation->payable_amount)}}</i></td>
                                <td class="col-5 pe-1">
                                Discount: <span class="float-end">{{currencySymbol($quotation->discount_amount)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-7 text-1">Note : {{$quotation->note}}</td>
                                <td class="col-5 pe-1 bg-light fw-semibold">
                                    Grand Total:<span class="float-end">{{currencySymbol($quotation->payable_amount)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-7 text-1">
                                    <div class="fw-semibold">Terms & Condition :</div>
                                    <div class="fw-semibold">{!!$quotation->terms_condition!!}</div>
                                </td>
                                <td class="col-5 pe-1 text-end">
                                    For, {{ app('general_setting')['company_name'] }}
                                    <div class="text-1 fst-italic mt-5">(Authorised Signatory)</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection