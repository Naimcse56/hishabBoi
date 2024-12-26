
@php
    $currentBalance = 0 + $filtered_account_balance;
    $total_receivable = 0;
    $total_payable = 0;
    $order_value = $work_order->order_value > 0 ? $work_order->order_value : 1;
    $est_cost = $work_order->work_order_estimation_costs()->sum('estimated_amount');
    $est_profit = $order_value - $est_cost;
    $est_profit_percent = $est_profit * 100 / $order_value;
    $actual_exp_cal = $expense_transactions->sum('amount') - $pay_expense_transactions->sum('amount');
    $actual_cost = $actual_exp_cal >= 0 ? $expense_transactions->sum('amount') : abs($actual_exp_cal)+$expense_transactions->sum('amount');
    $actual_profit = $order_value - $actual_cost;
    $actual_profit_percent = $actual_profit * 100 / $order_value;
@endphp
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="8" class="text-center sky-bg">
                <h6 class="mb-2">Work Order Report : {{$work_order->sub_ledger->name}} </h6>
                @isset($work_order)
                    <p class="mb-0">W/O : {{$work_order->order_name}}</p>
                    <p class="mb-0">({{$work_order->order_no}})</p>
                    <p class="mb-0">Order Date : {{$work_order->date}}</p>
                    @isset($site_detail)
                        <p class="mb-0">Site Name : {{$site_detail->site_name}}</p>
                    @endisset
                @endisset
            </th>
        </tr>
        <tr>
            <th colspan="5"></th>
            <td class="text-right"></td>
            <th class="text-right">Estimated</th>
            <th class="text-right">Actual</th>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Work Order Value</td>
            <td class="text-right"></td>
            <td class="text-right">{{number_format($order_value, 2)}}</td>
            <td class="text-right">{{number_format($order_value, 2)}}</td>
        </tr>
        @foreach ($work_order->work_order_estimation_costs as $estimation)
            <tr>
                <td colspan="5" class="text-right">{{ $estimation->ledger->name }}</td>
                <td class="text-right">{{ number_format($estimation->estimated_amount, 2, '.', '') }}</td>
                <td class="text-right"></td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="text-right">Total Cost Budget</td>
            <td class="text-right"></td>
            <td class="text-right">{{number_format($est_cost, 2)}}</td>
            <td class="text-right actual_cost">{{number_format($actual_cost, 2)}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Profit</td>
            <td class="text-right"></td>
            <td class="text-right">{{number_format($est_profit, 2)}}</td>
            <td class="text-right">{{number_format($actual_profit, 2)}}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">Profit Percentage</td>
            <td class="text-right"></td>
            <td class="text-right">{{number_format($est_profit_percent, 2)}} %</td>
            <td class="text-right">{{number_format($actual_profit_percent, 2)}} %</td>
        </tr>
        @if ($work_order->work_order_site_details()->count() > 0)
            <tr>
                <td colspan="8" class="text-center fw-semibold">Sites Information</td>
            </tr>
            <tr>
                <td colspan="5" class="fw-semibold">Site Name</td>
                <td class="fw-semibold">Site Location</td>
                <td class="fw-semibold">Est. Budget</td>
                <td class="fw-semibold">Site Manager</td>
            </tr>
            @foreach ($work_order->work_order_site_details as $site_detail)
            <tr>
                <td colspan="5">{{$site_detail->site_name}}</td>
                <td>{{$site_detail->site_location}}</td>
                <td>{{number_format($site_detail->est_budget, 2)}}</td>
                <td>{{$site_detail->site_pm_name}}</td>
            </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="8" class="text-center"></td>
        </tr>
        <tr>
            <td colspan="8" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</td>
        </tr>
        <tr>
            <th scope="col" class="text-center">Date</th>
            <th scope="col" class="text-center">Trn No.</th>
            <th scope="col" class="text-center">Narration</th>
            <th scope="col" class="text-center">Ledger</th>
            <th scope="col" class="text-right">Debit</th>
            <th scope="col" class="text-right">Credit</th>
            <th scope="col" colspan="2" class="text-right">Balance</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="6" class="text-right">Opening Balance</td>
            <td class="text-right nowrap" colspan="2">{{($filtered_account_balance)}}</td>
        </tr>
        <tr>
            <td colspan="8" class="fw-semibold">Billing Information</td>
        </tr>
        @foreach ($income_transactions as $key => $transaction)
            @php
                $total_receivable += $transaction->amount;
            @endphp
            <tr>
                <td class="nowrap">
                    {{ date('d-m-Y', strtotime(@$transaction->date)) }}
                </td>
                <td class="nowrap"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($transaction->voucher_id)) }}">{{  @$transaction->voucher->TypeName }}</a></td>
                <td>{{ $transaction->narration }}</td>
                <td>
                    <p class="fw-semibold mb-0 nowrap">{{ $transaction->ledger->name }}</p>
                    <p class="mb-0">{{ $transaction->work_order_site_detail_id > 0 ? 'Site : '.$transaction->work_order_site_detail->site_name : '' }}</p>
                </td>
                <td class="text-right nowrap">
                    @if ($transaction->type == "Dr")
                        {{ number_format($transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap">
                    @if ($transaction->type == "Cr")
                        {{ number_format($transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap" colspan="2">{{ $total_receivable >= 0 ? number_format($total_receivable, 2, '.', '') : '('.number_format(abs($total_receivable), 2, '.', '').')' }}</td>
            </tr>
        @endforeach
        
        @php
            $total_receive = $total_receivable;
        @endphp
        @foreach ($rcv_income_transactions as $key => $rcv_transaction)
            @php
                $total_receive -= $rcv_transaction->amount;
            @endphp
            <tr>
                <td class="nowrap">
                    {{ date('d-m-Y', strtotime(@$rcv_transaction->date)) }}
                </td>
                <td class="nowrap"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($rcv_transaction->voucher_id)) }}">{{  @$rcv_transaction->voucher->TypeName }}</a></td>
                <td>{{ $rcv_transaction->narration }}</td>
                <td>
                    <p class="fw-semibold mb-0 nowrap">{{ $rcv_transaction->ledger->name }}</p>
                    <p class="mb-0">{{ $rcv_transaction->work_order_site_detail_id > 0 ? 'Site : '.$rcv_transaction->work_order_site_detail->site_name : '' }}</p>
                </td>
                <td class="text-right nowrap">
                    @if ($rcv_transaction->type == "Dr")
                        {{ number_format($rcv_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap">
                    @if ($rcv_transaction->type == "Cr")
                        {{ number_format($rcv_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap" colspan="2">{{ $total_receive >= 0 ? number_format($total_receive, 2, '.', '') : '('.number_format(abs($total_receive), 2, '.', '').')' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right text-primary fw-semibold">Total</td>
            <td class="text-right text-primary">{{ number_format($rcv_income_transactions->where('type','Dr')->sum('amount') + $income_transactions->where('type','Dr')->sum('amount'), 2) }}</td>
            <td class="text-right text-primary">{{ number_format($rcv_income_transactions->where('type','Cr')->sum('amount') + $income_transactions->where('type','Cr')->sum('amount'), 2) }}</td>
            <td class="text-right nowrap text-primary" colspan="2">{{$total_receive >= 0 ? number_format($total_receive, 2) : '('.number_format(abs($total_receive), 2).')'}}</td>
        </tr>

        <tr>
            <td colspan="8" class="fw-semibold">Cost Information</td>
        </tr>
        @foreach ($expense_transactions as $key => $exp_transaction)
            @php
                $total_payable -= $exp_transaction->amount;
            @endphp
            <tr>
                <td class="nowrap">
                    {{ date('d-m-Y', strtotime(@$exp_transaction->date)) }}
                </td>
                <td class="nowrap"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($exp_transaction->voucher_id)) }}">{{  @$exp_transaction->voucher->TypeName }}</a></td>
                <td>{{ $exp_transaction->narration }}</td>
                <td>
                    <p class="fw-semibold mb-0 nowrap">{{ $exp_transaction->ledger->name }}</p>
                    <p class="mb-0">{{ $exp_transaction->work_order_site_detail_id > 0 ? 'Site : '.$exp_transaction->work_order_site_detail->site_name : '' }}</p>
                </td>
                <td class="text-right nowrap">
                    @if ($exp_transaction->type == "Dr")
                        {{ number_format($exp_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap">
                    @if ($exp_transaction->type == "Cr")
                        {{ number_format($exp_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap" colspan="2">{{ $total_payable >= 0 ? number_format($total_payable, 2, '.', '') : '('.number_format(abs($total_payable), 2, '.', '').')' }}</td>
            </tr>
        @endforeach
        @php
            $total_pay = $total_payable;
        @endphp
        @foreach ($pay_expense_transactions as $key => $pay_transaction)
            @php
                $total_pay += $pay_transaction->amount;
            @endphp
            <tr>
                <td class="nowrap">
                    {{ date('d-m-Y', strtotime(@$pay_transaction->date)) }}
                </td>
                <td class="nowrap"><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($pay_transaction->voucher_id)) }}">{{  @$pay_transaction->voucher->TypeName }}</a></td>
                <td>{{ $pay_transaction->narration }}</td>
                <td>
                    <p class="fw-semibold mb-0 nowrap">{{ $pay_transaction->ledger->name }}</p>
                    <p class="mb-0">{{ $pay_transaction->work_order_site_detail_id > 0 ? 'Site : '.$pay_transaction->work_order_site_detail->site_name : '' }}</p>
                </td>
                <td class="text-right nowrap">
                    @if ($pay_transaction->type == "Dr")
                        {{ number_format($pay_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap">
                    @if ($pay_transaction->type == "Cr")
                        {{ number_format($pay_transaction->amount, 2, '.', '') }}
                    @endif
                </td>
                <td class="text-right nowrap" colspan="2">{{ $total_pay >= 0 ? number_format($total_pay, 2, '.', '') : '('.number_format(abs($total_pay), 2, '.', '').')' }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right text-primary fw-semibold">Total</td>
            <td class="text-right text-primary">{{ number_format($expense_transactions->where('type','Dr')->sum('amount') + $pay_expense_transactions->where('type','Dr')->sum('amount'), 2) }}</td>
            <td class="text-right text-primary">{{ number_format($expense_transactions->where('type','Cr')->sum('amount') + $pay_expense_transactions->where('type','Cr')->sum('amount'), 2) }}</td>
            <td class="text-right nowrap text-primary" colspan="2">{{ $total_pay >= 0 ? number_format($total_pay, 2, '.', '') : '('.number_format(abs($total_pay), 2).')' }}</td>
        </tr>
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="8">
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