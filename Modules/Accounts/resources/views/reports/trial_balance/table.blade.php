@php
    $total_dr = 0;
    $total_cr = 0;
@endphp
<table class="table table-bordered mb-0" style="width:100%">
    <thead>
        <tr>
            <th scope="col" colspan="4" class="text-center sky-bg">
                <h5 class="mb-2">@isset($filtered_branch) {{$filtered_branch->name}} @endisset </h5>
                <h6 class="mb-2">@isset($filtered_branch) {{$filtered_branch->location}} @endisset </h6>
                <h6 class="mb-0">Trial Balance Report</h6>
            </th>
        </tr>
        <tr>
            <th scope="col" colspan="2" width="50%"></th>
            <th scope="col" class="text-center nowrap fs-14" colspan="2">Amount (BDT) <br>{{date('d.m.Y', strtotime($dateTo))}}</th>
        </tr>
        <tr>
            <th scope="col">Particular</th>
            <th scope="col">Code</th>
            <th scope="col" class="text-center">Debit Amount</th>
            <th scope="col" class="text-center">Credit Amount</th>
        </tr>
    </thead>
    <tbody>
        @isset($filtered_branch)
            @if ($first_section->count() > 0)
                <tr>
                    <td class="fw-bold" colspan="4">Assets</td>
                </tr>
                @foreach ($first_section->skip(1) as $k => $item)
                    @php
                        $debit = 0.00;
                        $credit = 0.00;
                        if (isset($item['children_balance']) && $item['children_balance'] != 0) {
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] > 0) {
                                $debit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                                $credit = number_format(abs($item['children_balance']), 2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] > 0) {
                                $credit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] < 0) {
                                $debit = number_format(abs($item['children_balance']), 2);
                            }
                        } else if (isset($item['children_balance']) && $item['children_balance'] == 0) {
                            $debit = !empty($item['debit']) ? $item['debit'] : '';
                            $credit = !empty($item['credit']) ? $item['credit'] : '';
                        }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                        @php
                            if (is_numeric(str_replace(',','',$debit))) {
                                $total_dr += str_replace(',','',$debit);
                            }
                            if (is_numeric(str_replace(',','',$credit))) {
                                $total_cr += str_replace(',','',$credit);
                            }
                        @endphp
                        <tr>
                            <td class=""><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($second_section->count() > 0)
                <tr>
                    <td class="fw-bold" colspan="4">Expenses</td>
                </tr>
                @foreach ($second_section->skip(1) as $k => $item)
                    @php
                        $debit = 0.00;
                        $credit = 0.00;
                        if (isset($item['children_balance']) && $item['children_balance'] != 0) {
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] > 0) {
                                $debit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                                $credit = number_format(abs($item['children_balance']), 2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] > 0) {
                                $credit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] < 0) {
                                $debit = number_format(abs($item['children_balance']), 2);
                            }
                        } else if (isset($item['children_balance']) && $item['children_balance'] == 0) {
                            $debit = !empty($item['debit']) ? $item['debit'] : '';
                            $credit = !empty($item['credit']) ? $item['credit'] : '';
                        }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                        @php
                            if (is_numeric(str_replace(',','',$debit))) {
                                $total_dr += str_replace(',','',$debit);
                            }
                            if (is_numeric(str_replace(',','',$credit))) {
                                $total_cr += str_replace(',','',$credit);
                            }
                        @endphp
                        <tr>
                            <td class=""><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($third_section->count() > 0)
                <tr>
                    <td class="fw-bold" colspan="4">Liabilities and Equities</td>
                </tr>
                @foreach ($third_section->skip(1) as $k => $item)
                    @php
                        $debit = 0.00;
                        $credit = 0.00;
                        if (isset($item['children_balance']) && $item['children_balance'] != 0) {
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] > 0) {
                                $debit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                                $credit = number_format(abs($item['children_balance']), 2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] > 0) {
                                $credit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] < 0) {
                                $debit = number_format(abs($item['children_balance']), 2);
                            }
                        } else if (isset($item['children_balance']) && $item['children_balance'] == 0) {
                            $debit = !empty($item['debit']) ? $item['debit'] : '';
                            $credit = !empty($item['credit']) ? $item['credit'] : '';
                        }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                        @php
                            if (is_numeric(str_replace(',','',$debit))) {
                                $total_dr += str_replace(',','',$debit);
                            }
                            if (is_numeric(str_replace(',','',$credit))) {
                                $total_cr += str_replace(',','',$credit);
                            }
                        @endphp
                        <tr>
                            <td class=""><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($fourth_section->count() > 0)
                <tr>
                    <td class="fw-bold" colspan="4">Revenues</td>
                </tr>
                @foreach ($fourth_section->skip(1) as $k => $item)
                    @php
                        $debit = 0;
                        $credit = 0;
                        if (isset($item['children_balance']) && $item['children_balance'] != 0) {
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] > 0) {
                                $debit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                                $credit = number_format(abs($item['children_balance']), 2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] > 0) {
                                $credit = number_format($item['children_balance'],2);
                            }
                            if (in_array($item['type'], [2,4,5]) && $item['children_balance'] < 0) {
                                $debit = number_format(abs($item['children_balance']), 2);
                            }
                        } else if (isset($item['children_balance']) && $item['children_balance'] == 0) {
                            $debit = !empty($item['debit']) ? $item['debit'] : '';
                            $credit = !empty($item['credit']) ? $item['credit'] : '';
                        }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                        @php
                            if (is_numeric(str_replace(',','',$debit))) {
                                $total_dr += str_replace(',','',$debit);
                            }
                            if (is_numeric(str_replace(',','',$credit))) {
                                $total_cr += str_replace(',','',$credit);
                            }
                        @endphp
                        <tr>
                            <td class=""><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <td class="fw-bold" colspan="2">Total</td>
                <td class="text-right nowrap">{{number_format($total_dr,2)}}</td>
                <td class="text-right nowrap">{{number_format($total_cr,2)}}</td>
            </tr>
        @endisset        
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="4">
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