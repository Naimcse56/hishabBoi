@extends('layouts.invoice')
@section('title')
Voucher Print
@endsection
@section('content')
@php
    $debit_info = $journal->transactions()->where('type','Dr')->first();
    $credit_info = $journal->transactions()->where('type','Cr')->first();
@endphp
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
                   <div class="col">Date: {{showDateFormat($journal->date)}}</div>
                   <div class="col text-center fw-semibold text-3 text-uppercase">{{strtoupper($journal->TypeDetails)}}</div>
                   <div class="col text-end">Voucher No: {{$journal->TypeName}}</div>
               </div>
           </td>
           </tr>
           <tr>
            <td colspan="2">Concern Person : {{$journal->concern_person}}</td>
           </tr>
           <tr>
               <td colspan="2" class="p-0">
                   <table class="table table-sm mb-0">
                       <thead>
                           <tr class="bg-light">
                               <td class="col-4"><strong>Ledger</strong></td>
                               <td class="text-center"><strong>Payee</strong></td>
                               <td class="col-2 text-end"><strong>Debit</strong></td>
                               <td class="col-2 text-end"><strong>Credit</strong></td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach ($journal->transactions as $item)
                           <tr>
                              <td>{{ $item->ledger->name }} {{ $item->ledger->ac_no ? '('.$item->ledger->ac_no.')' : '' }}</td>
                              <td class="text-center">
                                    {{ $item->sub_ledger->name }}</td>
                              <td class="text-end nowrap">
                                    {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                              </td>
                              <td class="text-end nowrap">
                                    {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                              </td>
                           </tr>
                     @endforeach
                       </tbody>
                   </table>
               </td>
           </tr>
           <tr>
               <td colspan="2">Particulars : {{$journal->narration}}</td>
           </tr>
           <tr class="bg-light fw-semibold">
               <td colspan="2" class="col-7 py-1">
                  <span class="fw-semibold">Total Amount:</span> <i>{{currencySymbol($journal->amount)}}</i>
               </td>
           </tr>
           <tr>
               <td colspan="2" class="col-7 text-1"><span class="fw-semibold">Bill Amount:</span> <i>{{convert_number($journal->amount)}}</i> Only</td>
           </tr>
       </tbody>
   </table>
   <footer class="text-center mt-4">
     <div class="btn-group btn-group-sm d-print-none"> <a href="{{route('opening-balance.index')}}" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-list"></i> Back To List</a> </div>
     <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print & Download</a> </div>
   </footer>
</div>
@endsection