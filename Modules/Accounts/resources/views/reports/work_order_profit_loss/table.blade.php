@php
    $total_direct_income = 0;
    $total_direct_expense = 0;
    $total_tax_expense = 0;
    $order_value = $work_order->order_value > 0 ? $work_order->order_value : 1;
    $est_cost = $work_order->work_order_estimation_costs()->sum('estimated_amount');
    $est_profit = $order_value - $est_cost;
    $est_profit_percent = $est_profit * 100 / $order_value;
@endphp
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="2" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-2">@isset($business_unit) {{$business_unit->name}} @endisset </h6>
                <h6 class="mb-2">Work Order Profit Loss Report : {{$work_order->sub_ledger->name}} </h6>
                @isset($work_order)
                    <p class="mb-0">W/O : {{$work_order->order_name}}</p>
                    <p class="mb-0">({{$work_order->order_no}})</p>
                    <p class="mb-0">Order Date : {{showDateFormat($work_order->date)}}</p>
                @endisset
                <p class="mb-0">As on {{date('d, F - Y', strtotime($dateTo))}}</p>
            </th>
        </tr>
        <tr>
            <td class="text-right"></td>
            <th class="text-right">Estimated</th>
        </tr>
        <tr>
            <td class="text-right">Work Order Value</td>
            <td class="text-right">{{number_format($order_value, 2)}}</td>
        </tr>
        @foreach ($work_order->work_order_estimation_costs as $estimation)
            <tr>
                <td class="text-right">{{ $estimation->ledger->name }}</td>
                <td class="text-right">{{ number_format($estimation->estimated_amount, 2, '.', '') }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="text-right">Total Cost Budget</td>
            <td class="text-right">{{number_format($est_cost, 2)}}</td>
        </tr>
        <tr>
            <td class="text-right">Profit</td>
            <td class="text-right">{{number_format($est_profit, 2)}}</td>
        </tr>
        <tr>
            <td class="text-right">Profit Percentage</td>
            <td class="text-right">{{number_format($est_profit_percent, 2)}} %</td>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <th scope="col" class="fs-14 text-center">Particular</th>
            <th scope="col" class="text-right nowrap fs-14" width="10%">Amount</th>
        </tr>
    </thead>
    <tbody>
        @if ($first_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$first_section->first()['code']}} : {{$first_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$first_section->sum('amount') >= 0 ? number_format($first_section->sum('amount'),2) : '('.number_format(abs($first_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($first_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</a></td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if ($fourth_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$fourth_section->first()['code']}} : {{$fourth_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$fourth_section->sum('amount') >= 0 ? number_format($fourth_section->sum('amount'),2) : '('.number_format(abs($fourth_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($fourth_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</a></td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td class="text-right fw-semibold">Total</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount'),2)}}</td>
            </tr>
        @endif
        <tr><td colspan="2"></td></tr>
        @if ($second_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$second_section->first()['code']}} : {{$second_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$second_section->sum('amount') >= 0 ? number_format($second_section->sum('amount'),2) : '('.number_format(abs($second_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($second_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</a></td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if ($third_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$third_section->first()['code']}} : {{$third_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$third_section->sum('amount') >= 0 ? number_format($third_section->sum('amount'),2) : '('.number_format(abs($third_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($third_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</a></td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if ($fifth_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$fifth_section->first()['code']}} : {{$fifth_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$fifth_section->sum('amount') >= 0 ? number_format($fifth_section->sum('amount'),2) : '('.number_format(abs($fifth_section->sum('amount')),2).')'}}</a></td>
            </tr>
            @foreach ($fifth_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</td>
                    </tr>
                @endif
            @endforeach
        @endif
        @if ($tax_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$tax_section->first()['code']}} : {{$tax_section->first()['name']}}</td>
                <td class="text-right nowrap">{{$tax_section->sum('amount') >= 0 ? number_format($tax_section->sum('amount'),2) : '('.number_format(abs($tax_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($tax_section->skip(1) as $item)
                @if ($item['amount'] != 0 || $item['children_balance'] != 0)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" class="text-black relative-z-index" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'work_order_id' =>$work_order->id])}}">{{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}}</a></td>
                    </tr>
                @endif
            @endforeach
        @endif
        <tr><td colspan="2"></td></tr>
        <tr>
            <td class="text-right fw-semibold">Total Expense</td>
            <td class="text-right nowrap fw-semibold">{{number_format($third_section->sum('amount') + $fifth_section->sum('amount') +  $second_section->sum('amount') + $tax_section->sum('amount'),2)}}</td>
        </tr>
        <tr>
            <td class="text-right fw-semibold">Net Profit Before TAX</td>
            <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount'),2)}}</td>
        </tr>
        <tr>
            <td class="text-right fw-semibold">Net Profit</td>
            <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount') - $tax_section->sum('amount'),2)}}</td>
        </tr>      
    </tbody>
</table>