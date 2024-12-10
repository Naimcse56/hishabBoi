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
            <th scope="col" class="nowrap fs-14" width="10%">Note</th>
            <th scope="col" class="text-right nowrap fs-14" width="10%">Amount (BDT) <br>{{date('d.m.Y', strtotime($dateTo))}}</th>
        </tr>
    </thead>
    <tbody>
        @isset($filtered_branch)
            @if ($first_section->count() > 0)
                @foreach ($first_section as $k => $item)
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
                    @if ((($item['view_in_bs'] == 1 && $amount != 0) || $k == 0))
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($second_section->count() > 0)
                @foreach ($second_section as $k => $item)
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
                    @if ((($item['view_in_bs'] == 1 && $amount != 0) || $k == 0))
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold">Gross Profit</td>
                <td></td>
                <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') - $second_section->sum('amount'),2)}}</td>
            </tr>
            @if ($third_section->count() > 0)
                @foreach ($third_section as $k => $item)
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
                    @if (($item['view_in_bs'] == 1 && $amount != 0) || $k == 0)
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="text-right fw-semibold">Income From Operation</td>
                    <td></td>
                    <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount'),2)}}</td>
                </tr>
            @endif
            @if ($fourth_section->count() > 0)
                @foreach ($fourth_section as $k => $item)
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
                    @if (($item['view_in_bs'] == 1 && $amount != 0) || $k == 0)
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="text-right fw-semibold">Total</td>
                    <td></td>
                    <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount'),2)}}</td>
                </tr>
            @endif
            @if ($fifth_section->count() > 0)
                @foreach ($fifth_section as $k => $item)
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
                    @if (($item['view_in_bs'] == 1 && $amount != 0) || $k == 0)
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold">Net Profit Before TAX</td>
                <td></td>
                <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount'),2)}}</td>
            </tr>
            @if ($tax_section->count() > 0)
                @foreach ($tax_section as $k => $item)
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
                    @if (($item['view_in_bs'] == 1 && $amount != 0) || $k == 0)
                        <tr>
                            <td class="{{$k == 0 ? 'fw-bold' : ''}}">{{$item['name']}}</td>
                            <td>{{$item['code']}}</td>
                            <td class="text-right nowrap {{$k == 0 ? 'fw-bold' : ''}}"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$amount >= 0 ? number_format($amount,2) : '('.number_format(abs($amount),2).')'}}</a></td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <td class="text-right fw-semibold">Net Profit</td>
                <td></td>
                <td class="text-right nowrap fw-semibold">{{number_format($first_section->sum('amount') + $fourth_section->sum('amount') - $second_section->sum('amount') - $third_section->sum('amount') - $fifth_section->sum('amount') - $tax_section->sum('amount'),2)}}</td>
            </tr>
        @endisset
        
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="3">
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