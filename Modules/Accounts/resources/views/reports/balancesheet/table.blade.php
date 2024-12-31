@php
    $total_direct_income = 0;
    $total_direct_expense = 0;
    $total_tax_expense = 0;
@endphp
<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="2" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-0">BALANCE SHEET</h6>
                <p class="mb-0">As on {{date('d, F - Y', strtotime($dateTo))}}</p>
            </th>
        </tr>
        <tr>
            <th scope="col" class="fs-14">Particular</th>
            <th scope="col" class="text-right nowrap fs-14" width="10%">Amount</th>
        </tr>
    </thead>
    <tbody>
        
        @if ($first_section->count() > 0)
            <tr>
                <td class="fw-semibold" style="text-align: left;">{{$first_section->first()['code']}} : {{$first_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$first_section->sum('amount') >= 0 ? number_format($first_section->sum('amount'),2) : '('.number_format(abs($first_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($first_section->skip(1) as $k => $item)
                @php
                    $amount = 0;
                    if ($k == 0) {
                        $amount = $item['children_balance'];
                    } elseif ($item['is_parent'] == "yes") {
                        $amount = $item['children_balance'] + $item['amount'];
                    }
                    else {
                        $amount = $item['amount'];
                    }
                    
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                    <td class="text-right nowrap"><a  style="z-index: 10; position: relative;" target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                </tr>
            @endforeach
        @endif
        @if ($second_section->count() > 0)
            <tr>
                <td class="fw-semibold" style="text-align: left;">{{$second_section->first()['code']}} : {{$second_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$second_section->sum('amount') >= 0 ? number_format($second_section->sum('amount'),2) : '('.number_format(abs($second_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($second_section->skip(1) as $k => $item)
            
                @php
                    $amount = 0;
                    if ($k == 0) {
                        $amount = $item['children_balance'];
                    } elseif ($item['is_parent'] == "yes") {
                        $amount = $item['children_balance'] + $item['amount'];
                    }
                    else {
                        $amount = $item['amount'];
                    }
                    
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;"> {{$item['code'].' : '}} {{$item['name']}}</td>
                    <td class="text-right nowrap"><a  style="z-index: 10; position: relative;" target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="fw-semibold text-right">Total</td>
            <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $second_section->sum('amount'),2)}}</td>
        </tr>
        @if ($third_section->count() > 0)
            <tr>
                <td class="fw-semibold">{{$third_section->first()['code']}} : {{$third_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$third_section->sum('amount') >= 0 ? number_format($third_section->sum('amount'),2) : '('.number_format(abs($third_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($third_section->skip(1) as $k => $item)
            
                @php
                    $amount = 0;
                    if ($k == 0) {
                        $amount = $item['children_balance'];
                    } elseif ($item['is_parent'] == "yes") {
                        $amount = $item['children_balance'] + $item['amount'];
                    }
                    else {
                        $amount = $item['amount'];
                    }
                    
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                    <td class="text-right nowrap"><a  style="z-index: 10; position: relative;" target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                </tr>
            @endforeach
        @endif
        @if ($fourth_section->count() > 0)
            <tr>
                <td class="fw-semibold" style="text-align: left;">{{$fourth_section->first()['code']}} : {{$fourth_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$fourth_section->sum('amount') >= 0 ? number_format($fourth_section->sum('amount'),2) : '('.number_format(abs($fourth_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($fourth_section->skip(1) as $k => $item)
            
                @php
                    $amount = 0;
                    if ($k == 0) {
                        $amount = $item['children_balance'];
                    } elseif ($item['is_parent'] == "yes") {
                        $amount = $item['children_balance'] + $item['amount'];
                    }
                    else {
                        $amount = $item['amount'];
                    }
                    
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                    <td class="text-right nowrap"><a  style="z-index: 10; position: relative;" target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="fw-semibold" style="text-align: left;">Retained Earnings</td>
            <td></td>
        </tr>
        <tr>
            <td class="" style="text-align: left;">Add: During The Year</td>
            <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $second_section->sum('amount') - $third_section->sum('amount') - $fourth_section->sum('amount') - $fifth_section->sum('amount'),2)}}</td>
        </tr>
        @if ($fifth_section->count() > 0)
            <tr>
                <td class="fw-semibold" style="text-align: left;">{{$fifth_section->first()['code']}} : {{$fifth_section->first()['name']}}</td>
                <td class="text-right nowrap fw-semibold">{{$fifth_section->sum('amount') >= 0 ? number_format($fifth_section->sum('amount'),2) : '('.number_format(abs($fifth_section->sum('amount')),2).')'}}</td>
            </tr>
            @foreach ($fifth_section->skip(1) as $k => $item)
            
                @php
                    $amount = 0;
                    if ($k == 0) {
                        $amount = $item['children_balance'];
                    } elseif ($item['is_parent'] == "yes") {
                        $amount = $item['children_balance'] + $item['amount'];
                    }
                    else {
                        $amount = $item['amount'];
                    }
                    
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                    <td class="text-right nowrap"><a  style="z-index: 10; position: relative;" target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td class="fw-semibold text-right">Total</td>
            <td class="text-right nowrap fw-semibold">{{number_format($third_section->sum('amount') + $fourth_section->sum('amount') + $fifth_section->sum('amount'),2)}}</td>
        </tr>

    </tbody>
</table>