@php
    $total_direct_income = 0;
    $total_direct_expense = 0;
    $total_tax_expense = 0;
@endphp
<table class="table table-bordered mb-0" style="width:100%">
    <thead>
        <tr>
            <th colspan="3" class="text-center sky-bg">
                <h5 class="mb-0">@isset($filtered_branch){{$filtered_branch->name}} @endisset </h5>
                <h6 class="mb-2">@isset($filtered_branch) {{$filtered_branch->location}} @endisset </h6>
                <h6 class="mb-2">@isset($business_unit) {{$business_unit->name}} @endisset </h6>
                <h6 class="mb-0">INCOME STATEMENT</h6>
                <p class="mb-0">As on {{date('d, F - Y', strtotime($dateTo))}}</p>
            </th>
        </tr>
        <tr>
            <th scope="col" class="fs-14">Particular</th>
            <th scope="col" class="text-center nowrap fs-14" width="10%">Amount (BDT) <br>{{date('Y', strtotime($dateFrom)) == date('Y', strtotime($dateTo)) ? date('Y', strtotime($dateFrom)).' - '.date('Y', strtotime($dateTo))+1 : date('Y', strtotime($dateFrom)).' - '.date('Y', strtotime($dateTo))}}</th>
            <th scope="col" class="text-center nowrap fs-14" width="10%">Amount (BDT) <br>{{$prve_date_end ? date('Y', strtotime($prve_date_from)).' - '.date('Y', strtotime($prve_date_end)) : ""}}</th>
        </tr>
    </thead>
    <tbody>
        @isset($filtered_branch)
            @if ($first_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$first_section->first()['code']}} : {{$first_section->first()['name']}}</td>
                    <td class="text-right nowrap fw-semibold">{{$first_section->sum('amount') >= 0 ? number_format($first_section->sum('amount'),2) : '('.number_format(abs($first_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap fw-semibold">{{$first_section->sum('prev_amount') >= 0 ? number_format($first_section->sum('prev_amount'),2) : '('.number_format(abs($first_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($first_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
            @endif
            @if ($second_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$second_section->first()['code']}} : {{$second_section->first()['name']}}</td>
                    <td class="text-right nowrap fw-semibold">{{$second_section->sum('amount') >= 0 ? number_format($second_section->sum('amount'),2) : '('.number_format(abs($second_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap fw-semibold">{{$second_section->sum('prev_amount') >= 0 ? number_format($second_section->sum('prev_amount'),2) : '('.number_format(abs($second_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($second_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold">Gross Profit</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('amount') - $second_section->sum('amount'),2)}}</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('prev_amount') - $second_section->sum('prev_amount'),2)}}</td>
            </tr>
            @if ($third_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$third_section->first()['code']}} : {{$third_section->first()['name']}}</td>
                    <td class="text-right nowrap fw-semibold">{{$third_section->sum('amount') >= 0 ? number_format($third_section->sum('amount'),2) : '('.number_format(abs($third_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap fw-semibold">{{$third_section->sum('prev_amount') >= 0 ? number_format($third_section->sum('prev_amount'),2) : '('.number_format(abs($third_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($third_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-right fw-semibold">Income From Operation</td>
                    <td class="text-right nowrap">{{number_format($first_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount'),2)}}</td>
                    <td class="text-right nowrap">{{number_format($first_section->sum('prev_amount') - $second_section->sum('prev_amount') - $third_section->sum('prev_amount'),2)}}</td>
                </tr>
            @endif
            @if ($fourth_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$fourth_section->first()['code']}} : {{$fourth_section->first()['name']}}</td>
                    <td class="text-right nowrap fw-semibold">{{$fourth_section->sum('amount') >= 0 ? number_format($fourth_section->sum('amount'),2) : '('.number_format(abs($fourth_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap fw-semibold">{{$fourth_section->sum('prev_amount') >= 0 ? number_format($fourth_section->sum('prev_amount'),2) : '('.number_format(abs($fourth_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($fourth_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-right fw-semibold" style="text-align: left;">Total</td>
                    <td class="text-right nowrap">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount'),2)}}</td>
                    <td class="text-right nowrap">{{number_format($first_section->sum('prev_amount') + $fourth_section->sum('prev_amount') - $second_section->sum('prev_amount') - $third_section->sum('prev_amount'),2)}}</td>
                </tr>
            @endif
            @if ($fifth_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$fifth_section->first()['code']}} : {{$fifth_section->first()['name']}}</td>
                    <td class="text-right nowrap fw-semibold">{{$fifth_section->sum('amount') >= 0 ? number_format($fifth_section->sum('amount'),2) : '('.number_format(abs($fifth_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap fw-semibold">{{$fifth_section->sum('prev_amount') >= 0 ? number_format($fifth_section->sum('prev_amount'),2) : '('.number_format(abs($fifth_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($fifth_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold" style="text-align: left;">Net Profit Before TAX</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount'),2)}}</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('prev_amount') + $fourth_section->sum('prev_amount') - $second_section->sum('prev_amount') - $third_section->sum('prev_amount') - $fifth_section->sum('prev_amount'),2)}}</td>
            </tr>
            @if ($tax_section->count() > 0)
                <tr>
                    <td class="fw-semibold" style="text-align: left;">{{$tax_section->first()['code']}} : {{$tax_section->first()['name']}}</td>
                    <td class="text-right nowrap">{{$tax_section->sum('amount') >= 0 ? number_format($tax_section->sum('amount'),2) : '('.number_format(abs($tax_section->sum('amount')),2).')'}}</td>
                    <td class="text-right nowrap">{{$tax_section->sum('prev_amount') >= 0 ? number_format($tax_section->sum('prev_amount'),2) : '('.number_format(abs($tax_section->sum('prev_amount')),2).')'}}</td>
                </tr>
                @foreach ($tax_section->skip(1) as $item)
                    <tr>
                        <td class="fw-semibold tabspace-{{$item['level']}}" style="text-align: left;">{{$item['name']}}</td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['children_balance'] >= 0 ? number_format($item['children_balance'],2) : '('.number_format(abs($item['children_balance']),2).')'}} @else {{$item['amount'] >= 0 ? number_format($item['amount'],2) : '('.number_format(abs($item['amount']),2).')'}} @endif</a></td>
                        <td class="text-right nowrap"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">@if($item['is_parent'] == "yes") {{$item['prev_children_balance'] >= 0 ? number_format($item['prev_children_balance'],2) : '('.number_format(abs($item['prev_children_balance']),2).')'}} @else {{$item['prev_amount'] >= 0 ? number_format($item['prev_amount'],2) : '('.number_format(abs($item['prev_amount']),2).')'}} @endif</a></td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold" style="text-align: left;">Net Profit</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount') - $tax_section->sum('amount'),2)}}</td>
                <td class="text-right nowrap">{{number_format($first_section->sum('prev_amount') + $fourth_section->sum('prev_amount') - $second_section->sum('prev_amount') - $third_section->sum('prev_amount') - $fifth_section->sum('prev_amount') - $tax_section->sum('prev_amount'),2)}}</td>
            </tr>
        @endisset        
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="2">
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