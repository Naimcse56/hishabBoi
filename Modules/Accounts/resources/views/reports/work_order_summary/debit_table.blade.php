{{-- 
@php
    $currentBalance = 0 + $filtered_account_balance;
    $total_receivable = 0;
    // $total_receive = 0;
    $total_payable = 0;
    // $total_pay = 0;
    $order_value = $work_order->order_value;
    $est_cost = $work_order->work_order_estimation_costs()->sum('estimated_amount');
    $est_profit = $order_value - $est_cost;
    $est_profit_percent = $est_profit * 100 / $order_value;
    $actual_exp_cal = $expense_transactions->sum('amount') - $pay_expense_transactions->sum('amount');
    $actual_cost = $actual_exp_cal >= 0 ? $expense_transactions->sum('amount') : abs($actual_exp_cal)+$expense_transactions->sum('amount');
    $actual_profit = $order_value - $actual_cost;
    $actual_profit_percent = $actual_profit * 100 / $order_value;
@endphp --}}
<table class="table table-bordered mb-0" style="width:100%">
    <thead>
        <tr>
            <th colspan="10" class="text-center sky-bg">
                <h5 class="mb-2">@isset($filtered_branch) {{$filtered_branch->name}} @endisset </h5>
                <h6 class="mb-2">@isset($filtered_branch) {{$filtered_branch->location}} @endisset </h6>
                <h6 class="mb-2">Work Order Report Summary</h6>
                <h6 class="mb-2">{{isset($client) ? 'Client : '.$client->name : ''}}</h6>
                <h6 class="mb-2">{{request('awarded_by') ? 'Awarded By : '.request('awarded_by') : ''}}</h6>
            </th>
        </tr>
        <tr>
            <td colspan="10" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</td>
        </tr>
        <tr>
            <th scope="col" style="width: 6%">Sl</th>
            <th scope="col" style="width: 20%">Client Name.</th>
            <th scope="col" style="width: 25%">Work Order Name</th>
            <th scope="col" style="width: 15%">W/O No.</th>
            <th scope="col" style="width: 6%">W/O Value</th>
            <th scope="col" style="width: 6%">Estimated Cost</th>
            <th scope="col" style="width: 6%">Estimated Profit</th>
            <th scope="col" style="width: 6%">Total Project Cost</th>
            <th scope="col" style="width: 6%">Total Payment</th>
            <th scope="col" style="width: 2%">% of Inv.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $key => $item)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item['customer']}}</td>
                <td>{{$item['name']}}</td>
                <td>{{chunk_split($item['code'], 10, ' ')}}</td>
                <td class="nowrap text-right">{{number_format($item['order_value'], 2)}}</td>
                <td class="nowrap text-right">{{number_format($item['estimated_cost'], 2)}}</td>
                <td class="nowrap text-right">{{number_format($item['estimated_profit'], 2)}}</td>
                <td class="nowrap text-right">{{number_format($item['total_exp'], 2)}}</td>
                <td class="nowrap text-right">{{number_format($item['total_payment'], 2)}}</td>
                <td class="nowrap text-right">{{number_format($item['investment_percent'], 2)}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="nowrap fw-semibold">Total</td>
            <td class="nowrap fw-semibold">{{number_format($reports->sum('order_value'), 2)}}</td>
            <td class="nowrap fw-semibold">{{number_format($reports->sum('estimated_cost'), 2)}}</td>
            <td class="nowrap fw-semibold">{{number_format($reports->sum('estimated_profit'), 2)}}</td>
            <td class="nowrap fw-semibold">{{number_format($reports->sum('total_exp'), 2)}}</td>
            <td class="nowrap fw-semibold">{{number_format($reports->sum('total_payment'), 2)}}</td>
            <td class="nowrap"></td>
        </tr>
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="10">
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