@php
    $currentBalance = 0;
    $total_dr = 0;
    $total_cr = 0;
@endphp
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="5" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-2">All Transactions </h6>
                <h6 class="mb-2">
                    @isset($filtered_account)
                        {{$filtered_account->name}}
                        {{$filtered_account->ac_no}}
                    @endisset
                </h6>
                <h6 class="mb-0">
                    @isset($party)
                        Party : {{$party->name}}
                    @endisset
                </h6>
            </th>
        </tr>
        <tr>
            <th colspan="5" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</th>
        </tr>
        <tr>
            <th scope="col" class="text-center">Date</th>
            <th scope="col" class="text-center">Trn No.</th>
            <th scope="col" class="text-center">Narration</th>
            <th scope="col" class="text-right" width="10%">Debit</th>
            <th scope="col" class="text-right" width="10%">Credit</th>
        </tr>
        <tr>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            @php
                $currentBalance = $transaction['type'] == "Cr" ? ($currentBalance + $transaction['amount']) :  ($currentBalance - $transaction['amount']);
            @endphp
            <tr>
                <td class="nowrap align-middle">
                    {{ showDateFormat(@$transaction['date']) }}
                </td>
                <td class="nowrap align-middle"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($transaction['voucher_id'])) }}">{{  @$transaction['txn_id'] }}</a></td>
                <td>
                    Narration : {{ $transaction['narration'] }} <br>
                    <p class="mb-0">
                        @if ($transaction['party_id'] > 0)                            
                        {{$transaction['party']}}<br>
                        @endif
                        @if($transaction['work_order_id'] > 0)
                            W/O : {{$transaction['work_order']}}<br>
                            W/O Client : {{$transaction['work_order_client']}}<br>
                        @endif
                        @if (isset($transaction['opposite_data']))
                            @foreach ($transaction['opposite_data'] as $opposite_data)
                                {{@$opposite_data['info_type']}} :
                                {{@$opposite_data['ledger']}} ;
                                {{@$opposite_data['party']}} <br>
                            @endforeach
                        @endif
                    </p>
                </td>
                <td class="text-right nowrap align-middle">
                    @if ($transaction['type'] == "Dr")
                        @php
                            $total_dr += $transaction['amount'];
                        @endphp
                        {{ number_format($transaction['amount'], 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap align-middle">
                    @if ($transaction['type'] == "Cr")
                        @php
                            $total_cr += $transaction['amount'];
                        @endphp
                        {{ number_format($transaction['amount'], 2, '.', '') }}
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">Current Period Total</td>
            <td class="text-right nowrap">{{$total_dr >= 0 ? number_format($total_dr, 2) : number_format(abs($total_dr), 2)}}</td>
            <td class="text-right nowrap">{{$total_cr < 0 ? number_format($total_cr, 2) : number_format(abs($total_cr), 2)}}</td>
        </tr>
        <tr>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right">Opening Balance</td>
            <td class="text-right nowrap">{{ $filtered_account_balance >= 0 ? number_format($filtered_account_balance, 2) : '('.number_format(abs($filtered_account_balance), 2).')' }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right">Add : Total Credit Balance</td>
            <td class="text-right nowrap">{{ $total_cr >= 0 ? number_format($total_cr, 2) : number_format(abs($total_cr), 2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right">Less : Total Debit Balance</td>
            <td class="text-right nowrap">{{ $total_dr >= 0 ? number_format($total_dr, 2) : number_format(abs($total_dr), 2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right">Ending Balance</td>
            <td class="text-right nowrap">{{ ($currentBalance + $filtered_account_balance) >= 0 ? number_format($currentBalance + $filtered_account_balance, 2) : '('.number_format(abs($currentBalance + $filtered_account_balance), 2).')' }}</td>
        </tr>
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="5">
                <div class="d-flex justify-content-between mt-25">
                    <p class="sign_dash">(PREPARED BY)</p>
                    <p class="sign_dash">(CHECKED BY)</p>
                    <p class="sign_dash">(HEAD OF CONCERN)</p>
                    <p class="sign_dash">(APPROVED BY)</p>
                </div>
            </td>
        </tr>
    </tfoot>
    @endif
</table>