@extends('layouts.admin_app')
@section('title')
Day Closing
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Check Before Closing Day</h4></div>            
            <div>
                @if ($row->is_closed != 1)
                <button type="button" onclick="closeDayAccounting('For {{$row->from_date}}', '{{ route('accountings.day_closing_confirm') }}', {{ $row->id }})" class="btn btn-sm btn-danger mt-4" id="basicAlert">
                    <i class="fa fa-bell"></i> Day Close Now
                </button>
                @else
                <button type="button" class="btn btn-sm btn-success mt-4" id="basicAlert">
                    <i class="fa fa-bell"></i> Already Closeed
                </button>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th width="20%"></th>
                                        <th colspan="2" class="text-center">Today Opening Balance</th>
                                        <th colspan="2" class="text-center">{{date('d/m/Y', strtotime($row->from_date))}}</th>
                                        <th colspan="1" class="text-center"></th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Ledger</th>
                                        <th width="10%" class="text-center">Debit</th>
                                        <th width="10%" class="text-center">Credit</th>
                                        <th width="20%" class="text-center">Debit</th>
                                        <th width="20%" class="text-center">Credit</th>
                                        <th width="10%" class="text-center nowrap">Closing Balance</th>
                                    </tr>
                                </thead>
                                @php
                                    $total_dr = 0;
                                    $total_cr = 0;
                                    $opening_dr = 0;
                                    $opening_cr = 0;
                                @endphp
                                <tbody>
                                    @foreach ($ledgers as $ledger)
                                        @php
                                            $total_dr += $ledger->debit;
                                            $total_cr += $ledger->credit;
                                        @endphp
                                        <tr>
                                            <td><a href="{{ route('accountings.ledger_report',['account_id' => $ledger->id, 'start_date' => date('d/m/Y', strtotime($row->from_date)), 'end_date' => date('d/m/Y', strtotime($row->from_date))]) }}" target="_blank" class="text-black">{{$ledger->name}} @if ($ledger->ac_no) ({{$ledger->ac_no}}) @endif</a></td>
                                            <td class="text-right nowrap">{{number_format($ledger->DebitBalanceAmountTillDate($row->from_date),2)}}</td>
                                            <td class="text-right nowrap">{{number_format($ledger->CreditBalanceAmountTillDate($row->from_date),2)}}</td>
                                            <td class="text-right nowrap">{{number_format($ledger->DebitBalanceAmountOnDate($row->from_date),2)}}</td>
                                            <td class="text-right nowrap">{{number_format($ledger->CreditBalanceAmountOnDate($row->from_date),2)}}</td>
                                            <td class="text-right nowrap">{{number_format($ledger->BalanceAmount,2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td class="text-right nowrap">{{number_format($total_dr,2)}}</td>
                                        <td class="text-right nowrap">{{number_format($total_cr,2)}}</td>
                                        <td class="text-right nowrap"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection