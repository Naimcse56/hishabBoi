
@php
    $currentBalance = 0;
    $total_dr = 0;
    $total_cr = 0;
@endphp
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="7" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-1">Party Account Report @if (Route::is('accountings.sub_ledger_report_preview')) Preview @endif
                    @isset($ledger)
                    ({{$ledger->name}})
                    @endisset</h6>
                <h6 class="mb-1">
                    @isset($filtered_account)
                    {{ucwords(request('type'))}} : {{$filtered_account->name}} ({{$filtered_account->code}})
                    @endisset
                </h6>
            </th>
        </tr>
        <tr>
            <th colspan="7" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</th>
        </tr>
        <tr>
            <th scope="col" width="4%">Sl No.</th>
            <th scope="col" class="text-center">Date</th>
            <th scope="col" class="text-center">Trn No.</th>
            <th scope="col" class="text-center" width="30%">Narration</th>
            <th scope="col" class="text-right" width="8%">Debit</th>
            <th scope="col" class="text-right" width="8%">Credit</th>
            <th scope="col" class="text-right" width="8%">Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $key => $transaction)
            @php
                $currentBalance = $transaction['type'] == "Cr" ? ($currentBalance + $transaction['amount']) :  ($currentBalance - $transaction['amount']);
            @endphp
            <tr>
                <td style="vertical-align:middle;">{{$key+1}}</td>
                <td class="nowrap " style="vertical-align:middle;">
                    {{ date('d-m-Y', strtotime(@$transaction['date'])) }}
                </td>
                <td class="nowrap " style="vertical-align:middle;"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($transaction['voucher_id'])) }}">{{  @$transaction['txn_id'] }}</a></td>
                <td>
                    {{$transaction['particular']}} ;<br>
                    @if($transaction['work_order_id'] > 0)
                        W/O : {{$transaction['work_order']}}<br>
                        W/O Client : {{$transaction['work_order_client']}}<br>
                        W/O Site : {{$transaction['work_order_site']}}<br>
                    @endif
                    {{ $transaction['narration'] }}</td>
                <td class="text-right nowrap " style="vertical-align:middle;">
                    @if ($transaction['type'] == "Cr")
                        @php
                            $total_dr += $transaction['amount'];
                        @endphp
                        {{ number_format($transaction['amount'], 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap " style="vertical-align:middle;">
                    @if ($transaction['type'] == "Dr")
                        @php
                            $total_cr += $transaction['amount'];
                        @endphp
                        {{ number_format($transaction['amount'], 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap " style="vertical-align:middle;">{{ number_format($currentBalance, 2, '.', '') }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6" class="text-right">Opening Balance</td>
            <td class="text-right nowrap">{{$filtered_account_balance >= 0 ? number_format($filtered_account_balance, 2) : '('.number_format(abs($filtered_account_balance), 2).')'}}</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right">Current Period Balance</td>
            <td class="text-right nowrap">{{ $currentBalance >= 0 ? number_format($currentBalance, 2) : '('.number_format(abs($currentBalance), 2).')' }}</td>
        </tr>
        <tr>
            <td colspan="6" class="text-right">Closing Balance</td>
            <td class="text-right nowrap">{{ ($currentBalance + $filtered_account_balance) >= 0 ? number_format($currentBalance + $filtered_account_balance, 2) : '('.number_format(abs($currentBalance + $filtered_account_balance), 2).')' }}</td>
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
                </div>
            </td>
        </tr>
    </tfoot>
    @endif
</table>