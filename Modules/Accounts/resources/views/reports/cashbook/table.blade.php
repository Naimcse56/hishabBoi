
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
            <th colspan="7" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h5 class="mb-0">Cash Book : 
                    @isset($filtered_account)
                        {{$filtered_account->name}}
                    @endisset</h5>
                <p class="mb-0">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</p>
            </th>
        </tr>
        <tr>
            <th scope="col" width="5%">Sl No.</th>
            <th scope="col">Date.</th>
            <th scope="col">Particular</th>
            <th scope="col">Voucher Type</th>
            <th scope="col">Trn No.</th>
            <th scope="col" class="text-right">Receipt</th>
            <th scope="col" class="text-right">Payment</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            <tr>
                <td>{{$key+1}}</td>
                <td class="nowrap align-middle">{{date('d-m-Y', strtotime($transaction['date']))}}</td>
                <td><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($transaction['voucher_id'])) }}">
                    <p class="mb-0 fw-semibold">
                        @if (isset($transaction['opposite_data']))
                            @foreach ($transaction['opposite_data'] as $opposite_data)
                                {{@$opposite_data['info_type']}} :
                                {{@$opposite_data['ledger']}} ;
                                {{@$opposite_data['party']}} <br>
                            @endforeach
                        @endif
                    </p>
                    <p class="mb-0 fw-semibold">
                        {{$transaction['type'].' Info : '.$transaction['particular']}}
                    </p>
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
                    </a>
                </td>
                <td class="align-middle">{{str_replace('_',' ',$transaction['voucher_type'])}}</td>
                <td class="nowrap align-middle"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($transaction['voucher_id'])) }}">{{$transaction['txn_id']}}</a></td>
                <td class="text-right nowrap align-middle">{{ ($transaction['type'] == "Dr" && $transaction['is_opening'] != 1) ? number_format($transaction['amount'], 2) : (($transaction['type'] == "Dr" && $transaction['is_opening'] == 1) ? number_format($transaction['amount'], 2) : '') }}</td>
                <td class="text-right nowrap align-middle">{{ ($transaction['type'] == "Cr" && $transaction['is_opening'] != 1) ? number_format($transaction['amount'], 2) : (($transaction['type'] == "Cr" && $transaction['is_opening'] == 1) ? number_format($transaction['amount'], 2) : '') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5"></td>
            <td class="text-right nowrap fw-semibold">{{number_format(abs($total_rcv)+$opening_add_today, 2)}}</td>
            <td class="text-right nowrap fw-semibold">{{number_format(abs($total_pay), 2)}}</td>
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
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="7">
                <div class="d-flex justify-content-between mt-25">
                    <p class="sign_dash">(PREPARED BY)</p>
                    <p class="sign_dash">(CHECKED BY)</p>
                    <p class="sign_dash">(HEAD OF CONCERN)</p>
                    <p class="sign_dash">(APPROVED BY)</p>
                    <p class="sign_dash">(APPROVED BY)</p>
                </div>
            </td>
        </tr>
    </tfoot>
    @endif
</table>