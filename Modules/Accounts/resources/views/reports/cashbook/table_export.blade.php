
@php
$opening_add_today = $transactions->where('type','Dr')->where('is_opening',1)->whereNotIn('voucher_type',['pay_cash','pay_bank','pay','rcv_bank','rcv_cash','rcv'])->sum('amount') - $transactions->where('type','Cr')->where('is_opening',1)->whereNotIn('voucher_type',['pay_cash','pay_bank','pay','rcv_bank','rcv_cash','rcv'])->sum('amount');
$total_opening = number_format($opening, 2,".","");
$total_rcv = number_format($transactions->where('type','Dr')->where('is_opening',0)->sum('amount'), 2,".","");
$total_pay = number_format($transactions->where('type','Cr')->where('is_opening',0)->sum('amount'), 2,".","");
$difference = $total_opening+$opening_add_today + abs($total_rcv) - abs($total_pay);
@endphp
<table class="table table-bordered mb-0" style="width:100%">
    <thead>
        <tr>
            <th colspan="7" class="text-center">
                <h5 class="mb-0">@isset($filtered_branch){{$filtered_branch->name}} @endisset </h5>
                <h6 class="mb-2">@isset($filtered_branch) {{$filtered_branch->location}} @endisset </h6>
                <h6 class="mb-0">Cash Book @if(Route::is('accountings.cashbook_preview')) Preview @endif : 
                    @isset($filtered_account)
                        {{$filtered_account->name}}
                    @endisset</h6>
            </th>
        </tr>
        <tr>
            <th colspan="8">
                Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}
            </th>
        </tr>
        <tr>
            <th scope="col" width="5%">Sl No.</th>
            <th scope="col">Date.</th>
            <th scope="col">Particular</th>
            <th scope="col">Voucher Type</th>
            {{-- <th scope="col">SSID</th> --}}
            <th scope="col">Trn No.</th>
            <th scope="col" class="text-right">Receipt (BDT)</th>
            <th scope="col" class="text-right">Payment (BDT)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            <tr>
                <td>{{$key+1}}</td>
                <td class="nowrap">{{date('d-m-Y', strtotime($transaction['date']))}}</td>
                <td>
                    {{$transaction['particular']}}
                    <p class="mb-0">
                        @if ($transaction['party_id'] > 0)                            
                        {{$transaction['party']}}<br>
                        @endif
                        @if($transaction['work_order_id'] > 0)
                            W/O : {{$transaction['work_order']}}<br>
                            W/O Client : {{$transaction['work_order_client']}}<br>
                            W/O Site : {{$transaction['work_order_site']}}<br>
                        @endif
                        Narration : {{$transaction['narration']}}
                    </p>
                    @if (isset($transaction['opposite_data']))
                        @foreach ($transaction['opposite_data'] as $opposite_data)
                            {{@$opposite_data['info_type']}} :
                            {{@$opposite_data['ledger']}} ;
                            {{@$opposite_data['party']}} <br>
                        @endforeach
                    @endif
                </td>
                <td>{{str_replace('_',' ',$transaction['voucher_type'])}}</td>
                {{-- <td>{{$transaction['voucher_id']}}</td> --}}
                <td class="nowrap">{{$transaction['txn_id']}}</td>
                <td class="text-right nowrap">{{ ($transaction['type'] == "Dr" && $transaction['is_opening'] != 1) ? number_format($transaction['amount'], 2) : (($transaction['type'] == "Dr" && $transaction['is_opening'] == 1) ? number_format($transaction['amount'], 2) : '') }}</td>
                <td class="text-right nowrap">{{ ($transaction['type'] == "Cr" && $transaction['is_opening'] != 1) ? number_format($transaction['amount'], 2) : (($transaction['type'] == "Cr" && $transaction['is_opening'] == 1) ? number_format($transaction['amount'], 2) : '') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5"></td>
            <td class="text-right nowrap fw-bold">{{number_format(abs($total_rcv)+$opening_add_today, 2)}}</td>
            <td class="text-right nowrap fw-bold">{{number_format(abs($total_pay), 2)}}</td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Opening Balance</td>
            <td colspan="2" class="text-right nowrap">{{$total_opening > 0 ? number_format($total_opening, 2) : '('.number_format(abs($total_opening), 2).')'}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Add : Receipt</td>
            <td colspan="2" class="text-right nowrap">{{number_format(abs($total_rcv)+$opening_add_today, 2)}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Less : Payment</td>
            <td colspan="2" class="text-right nowrap">{{number_format(abs($total_pay), 2)}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Closing Balance</td>
            <td colspan="2" class="text-right nowrap">{{$difference > 0 ? number_format($difference, 2) : '('.number_format(abs($difference), 2).')'}}</td>
        </tr>
        {{-- <tr>
            <td colspan="6" class="text-right">Total :</td>
            <td class="text-right nowrap">{{ number_format($total_rcv,2) }}</td>
            <td class="text-right nowrap">{{ number_format($total_pay,2) }}</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right">Closing Balance :</td>
            <td class="text-right"></td>
            <td class="text-right">{{ $difference }}</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right"></td>
            <td class="text-right">{{ number_format($total_rcv,2) }}</td>
            <td class="text-right">{{ number_format($total_pay,2) }}</td>
        </tr> --}}
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="7">
                <div class="d-flex justify-content-between mt-25">
                    <p class="sign_dash">(Prepared by)</p>
                    <p class="sign_dash">(Verified by)</p>
                    <p class="sign_dash">(Checked by)</p>
                    <p class="sign_dash">(GM)</p>
                    <p class="sign_dash">(Head of Accounts)</p>
                </div>
            </td>
        </tr>
    </tfoot>
    @endif
</table>