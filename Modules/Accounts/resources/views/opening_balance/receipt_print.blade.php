@extends('accounts::print_layouts.index')
@section('title')
Voucher Print
@endsection
@section('content')
@php
    $debit_info = $journal->transactions()->where('type','Dr')->first();
    $credit_info = $journal->transactions()->where('type','Cr')->first();
@endphp

<div class="row" style="margin-top: 5px;">
    <div class="col-4" style="font-size: 14px;">
          <p class="mb-0" style="border: 1px solid #000; padding: 5px;">TK. = {{number_format($journal->amount, 2)}}</p>
    </div>
    <div class="col-4" style="font-size: 14px; text-align: center;">
          <p class="mb-0" style="border: 1px solid #000; padding: 5px; border-radius: 100px;">OPENING VOUCHER</p>
    </div>
    <div class="col-4" style="font-size: 14px; text-align: right;">
          <p class="mb-0">Voucher No : <span style="border-bottom: 1px dotted #000; min-width: 80px; padding: 5px">{{$journal->TypeName}}</span></p>
    </div>
    <div class="col-md-12" style="text-align: right;">
       <p class="mb-0">Date : <span style="border-bottom: 1px dotted #000; min-width: 80px; padding: 5px">{{ date('d-m-Y', strtotime($journal->date)) }}</span></p>
    </div>
</div>
<div class="row" style="margin-top: 5px;">
   <div class="col-md-12" style="font-size: 14px;">
      <p class="mb-2" style="border-bottom: 1px dotted #000; width: 100%">Taka (In&nbsp;Words) :&nbsp;<span>{{convert_number($journal->amount)}}          &nbsp;Only</span></p>
   </div>
</div>
<div class="row">   
   @php
       $total_debit = 0;
       $total_credit = 0;
   @endphp
   <div class="col-md-12">
       <div class="table table-responsive">
           <table class="table table_modal table-bordered mb-1">
               <thead>
                   <tr>
                       <th scope="col" width="30%">Ledger</th>
                       <th scope="col">Party</th>
                       <th scope="col" width="15%">Debit (BDT)</th>
                       <th scope="col" width="15%">Credit (BDT)</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($journal->transactions as $item)
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
                           </td>
                           <td>
                               {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                           </td>
                           <td>
                               {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                           </td>
                       </tr>
                   @endforeach
                   <tr>
                       <td colspan="2">Total Amount</td>
                       <td class="nowrap" id="total_debit"> {{ number_format($total_debit, 2) }}</td>
                       <td class="nowrap" id="total_credit"> {{ number_format($total_credit, 2) }}</td>
                   </tr>
               </tbody>
           </table>
       </div>
   </div>
</div>
<div class="row" style="margin-top: 0px;">
   <div class="col-md-12" style="font-size: 14px;">
         <p class="mb-2">Concern Person :&nbsp;<span>{{$journal->concern_person}}</span></p>
         <p class="mb-0">Purpose :&nbsp;<span>{{$journal->narration}}</span></p>
   </div>
</div>
<div class="row" style="margin-top: 45px;">
   <div class="col-md-12 d-flex justify-content-between" style="font-size: 14px; padding-bottom: 10px;">
         <p class="mb-0" style="border-top: 1px #666666 solid;">Prepared By</p>
         <p class="mb-0" style="border-top: 1px #666666 solid;">Checked By</p>
         <p class="mb-0" style="border-top: 1px #666666 solid;">Head of Concern</p>
         <p class="mb-0" style="border-top: 1px #666666 solid;">Approved By</p>
         <p class="mb-0" style="border-top: 1px #666666 solid;">Approved By</p>
   </div>
</div>

@endsection