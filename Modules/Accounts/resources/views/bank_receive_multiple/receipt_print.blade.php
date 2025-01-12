

@extends('accounts::print_layouts.index')
@section('title')
Voucher Print
@endsection
@section('content')
@php
    $debit_infos = $journal->transactions()->where('type','Cr')->get();
    $credit_infos = $journal->transactions()->where('type','Dr')->get();
@endphp

<div class="row mt-5">
   <div class="col-4 fs-14">
         <p class="mb-0" style="border: 1px solid #000; padding: 5px;">Amount = {{number_format($journal->amount, 2)}}</p>
   </div>
   <div class="col-4" style="font-size: 14px; text-align: center;">
         <p class="mb-0" style="border: 1px solid #000; padding: 5px; border-radius: 100px;">{{strtoupper($journal->TypeDetails)}}</p>
   </div>
   <div class="col-4" style="font-size: 14px; text-align: right;">
         <p class="mb-0">Voucher No : <span style="border-bottom: 1px dotted #000; min-width: 80px; padding: 5px">{{$journal->TypeName}}</span></p>
   </div>
   <div class="col-md-12 text-right">
      <p class="mb-0">Date : <span style="border-bottom: 1px dotted #000; min-width: 80px; padding: 5px">{{ date('d-m-Y', strtotime($journal->date)) }}</span></p>
   </div>
</div>
<div class="row mt-5">
   <div class="col-md-12 fs-14">
      <p class="mb-2" style="border-bottom: 1px dotted #000; width: 100%">Amount (In Words) :&nbsp;<span>{{convert_number($journal->amount)}} Only</span></p>
   </div>
</div>
<div class="row mt-5">
   <div class="col-md-12 fs-14">
      <table class="table table-bordered mb-1">
         <thead>
            <tr>
                <th scope="col" width="30%">Ledger</th>
                <th scope="col">Payee</th>
                <th scope="col" width="15%">Debit</th>
                <th scope="col" width="15%">Credit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journal->transactions as $item)
                <tr>
                     <td>{{ $item->ledger->name }} {{ $item->ledger->ac_no ? '('.$item->ledger->ac_no.')' : '' }}</td>
                     <td>
                           {{ $item->sub_ledger->name }}</td>
                     <td>
                           {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                     </td>
                     <td>
                           {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                     </td>
                </tr>
            @endforeach
        </tbody>
      </table>
   </div>
</div>
<div class="row" style="margin-top: 3px; padding-bottom: 5px;">
   <div class="col-md-12 fs-14">
      <div style="border: 1px solid; padding-left: 5px; padding-right: 5px;">
         <p class="mb-0">Particulars :&nbsp;<span>{{$journal->narration}}</span></p>
         <p class="mb-2">Concern Person :&nbsp;<span>{{$journal->concern_person}}</span></p>
      </div>
   </div>
</div>
@foreach ($credit_infos as $credit_info)
<div class="row" style="margin-top: 5px; margin-left: 1px; margin-right: 1px; padding-bottom: 5px;">
   <div class="col-md-12" style="border: 1px solid #000;font-size: 14px; padding: 5px;">
      <p class="mb-0">Narration : <span>{{$credit_info->narration}}</span></p>
   </div>
   @if ($credit_info->work_order_id > 0)
      <div class="col-md-12 d-flex justify-content-between" style="border: 1px solid #000;font-size: 14px; padding: 5px;">
         <p class="mb-0">W/O Name. : <span>{{$credit_info->work_order->order_name}}</span><br>
            Client Name. : <span>{{$credit_info->work_order->sub_ledger->name}}</span>
         </p>
         <p class="mb-0">W/O Num. : <span>{{$credit_info->work_order->order_no}}</span><br>
            Site Name. : <span>{{$credit_info->work_order_site_detail->site_name}}</p>
      </div>
   @endif
</div>
@endforeach
<div class="row mt-45">
   <div class="col-md-12 d-flex justify-content-between signing-footer">
         <p class="mb-0 top-border-signing">Prepared By</p>
         <p class="mb-0 top-border-signing">Checked By</p>
         <p class="mb-0 top-border-signing">Head of Concern</p>
         <p class="mb-0 top-border-signing">Received By</p>
   </div>
</div>
@endsection