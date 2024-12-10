@php
    $total_dr = 0;
    $total_cr = 0;
    $total_dr_prev = 0;
    $total_cr_prev = 0;
@endphp
{{-- jei parent er baccha show hobe shei parent er sathe display hoa balance ta jog hobe na finally --}}
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
            <th scope="col" colspan="2" width="60%"></th>
            <th scope="col" class="text-center nowrap fs-14" colspan="2">Amount (BDT) <br>{{date('Y', strtotime($dateFrom)).' - '.date('Y', strtotime($dateTo))}}</th>
            {{-- <th scope="col" class="text-center nowrap fs-14" colspan="2">Amount (BDT) <br>{{$prve_date_end ? date('Y', strtotime($prve_date_from)).' - '.date('Y', strtotime($prve_date_end)) : ""}}</th> --}}
        </tr>
        <tr>
            <th scope="col">Particular</th>
            <th scope="col">Code</th>
            <th scope="col" class="text-center">Debit Amount</th>
            <th scope="col" class="text-center">Credit Amount</th>
            {{-- <th scope="col" class="text-center">Debit Amount</th>
            <th scope="col" class="text-center">Credit Amount</th> --}}
        </tr>
    </thead>
    <tbody>
        @isset($filtered_branch)
            @if ($first_section->count() > 0)
            <tr>
                <td class="fw-bold" colspan="6" style="text-align: left;">Assets</td>
            </tr>
                @foreach ($first_section->skip(1) as $k => $item)
                    @php
                        $debit = 0;
                        $credit = 0;
                        $prev_debit = 0;
                        $prev_credit = 0;
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
                        // if (isset($item['prev_children_balance']) && $item['prev_children_balance'] != 0) {
                        //     if (in_array($item['type'], [1,3]) && $item['prev_children_balance'] > 0) {
                        //         $prev_debit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                        //         $prev_credit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] > 0) {
                        //         $prev_credit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] < 0) {
                        //         $prev_debit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        // } else if (isset($item['prev_children_balance']) && $item['prev_children_balance'] == 0) {
                        //     $prev_debit = !empty($item['prev_debit']) ? $item['prev_debit'] : '';
                        //     $prev_credit = !empty($item['prev_credit']) ? $item['prev_credit'] : '';
                        // }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                    @php
                        if (is_numeric(str_replace(',','',$debit)) && $item['parent_sum'] == "do_sum") {
                            $total_dr += str_replace(',','',$debit);
                        }
                        if (is_numeric(str_replace(',','',$credit)) && $item['parent_sum'] == "do_sum") {
                            $total_cr += str_replace(',','',$credit);
                        }
                        // if (is_numeric(str_replace(',','',$prev_debit)) && $item['parent_sum'] == "do_sum") {
                        //     $total_dr_prev += str_replace(',','',$prev_debit);
                        // }
                        // if (is_numeric(str_replace(',','',$prev_credit)) && $item['parent_sum'] == "do_sum") {
                        //     $total_cr_prev += str_replace(',','',$prev_credit);
                        // }
                    @endphp
                        <tr>
                            <td class="tabspace-{{$item['level']}}" style="text-align: left;"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                            {{-- <td class="text-right nowrap">{{$prev_debit}}</td>
                            <td class="text-right nowrap">{{$prev_credit}}</td> --}}
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($second_section->count() > 0)
            <tr>
                <td class="fw-bold" colspan="6" style="text-align: left;">Expenses</td>
            </tr>
                @foreach ($second_section->skip(1) as $k => $item)
                    @php
                        $debit = 0;
                        $credit = 0;
                        $prev_debit = 0;
                        $prev_credit = 0;
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
                        // if (isset($item['prev_children_balance']) && $item['prev_children_balance'] != 0) {
                        //     if (in_array($item['type'], [1,3]) && $item['prev_children_balance'] > 0) {
                        //         $prev_debit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                        //         $prev_credit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] > 0) {
                        //         $prev_credit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] < 0) {
                        //         $prev_debit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        // } else if (isset($item['prev_children_balance']) && $item['prev_children_balance'] == 0) {
                        //     $prev_debit = !empty($item['prev_debit']) ? $item['prev_debit'] : '';
                        //     $prev_credit = !empty($item['prev_credit']) ? $item['prev_credit'] : '';
                        // }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                    @php
                        if (is_numeric(str_replace(',','',$debit))) {
                            $total_dr += str_replace(',','',$debit);
                        }
                        if (is_numeric(str_replace(',','',$credit))) {
                            $total_cr += str_replace(',','',$credit);
                        }
                        // if (is_numeric(str_replace(',','',$prev_debit))) {
                        //     $total_dr_prev += str_replace(',','',$prev_debit);
                        // }
                        // if (is_numeric(str_replace(',','',$prev_credit))) {
                        //     $total_cr_prev += str_replace(',','',$prev_credit);
                        // }
                    @endphp
                        <tr>
                            <td class="tabspace-{{$item['level']}}" style="text-align: left;"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                            {{-- <td class="text-right nowrap">{{$prev_debit}}</td>
                            <td class="text-right nowrap">{{$prev_credit}}</td> --}}
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($third_section->count() > 0)
            <tr>
                <td class="fw-bold" colspan="6" style="text-align: left;">Liabilities and Equities</td>
            </tr>
                @foreach ($third_section->skip(1) as $k => $item)
                    @php
                        $debit = 0;
                        $credit = 0;
                        $prev_debit = 0;
                        $prev_credit = 0;
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
                        // if (isset($item['prev_children_balance']) && $item['prev_children_balance'] != 0) {
                        //     if (in_array($item['type'], [1,3]) && $item['prev_children_balance'] > 0) {
                        //         $prev_debit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                        //         $prev_credit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] > 0) {
                        //         $prev_credit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] < 0) {
                        //         $prev_debit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        // } else if (isset($item['prev_children_balance']) && $item['prev_children_balance'] == 0) {
                        //     $prev_debit = !empty($item['prev_debit']) ? $item['prev_debit'] : '';
                        //     $prev_credit = !empty($item['prev_credit']) ? $item['prev_credit'] : '';
                        // }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                    @php
                        if (is_numeric(str_replace(',','',$debit))) {
                            $total_dr += str_replace(',','',$debit);
                        }
                        if (is_numeric(str_replace(',','',$credit))) {
                            $total_cr += str_replace(',','',$credit);
                        }
                        // if (is_numeric(str_replace(',','',$prev_debit))) {
                        //     $total_dr_prev += str_replace(',','',$prev_debit);
                        // }
                        // if (is_numeric(str_replace(',','',$prev_credit))) {
                        //     $total_cr_prev += str_replace(',','',$prev_credit);
                        // }
                    @endphp
                        <tr>
                            <td class="tabspace-{{$item['level']}}" style="text-align: left;"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                            {{-- <td class="text-right nowrap">{{$prev_debit}}</td>
                            <td class="text-right nowrap">{{$prev_credit}}</td> --}}
                        </tr>
                    @endif
                @endforeach
            @endif
            @if ($fourth_section->count() > 0)
            <tr>
                <td class="fw-bold" colspan="6" style="text-align: left;">Revenues</td>
            </tr>
                @foreach ($fourth_section->skip(1) as $k => $item)
                    @php
                        $debit = 0;
                        $credit = 0;
                        $prev_debit = 0;
                        $prev_credit = 0;
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
                        // if (isset($item['prev_children_balance']) && $item['prev_children_balance'] != 0) {
                        //     if (in_array($item['type'], [1,3]) && $item['prev_children_balance'] > 0) {
                        //         $prev_debit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [1,3]) && $item['children_balance'] < 0) {
                        //         $prev_credit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] > 0) {
                        //         $prev_credit = number_format($item['prev_children_balance'],2);
                        //     }
                        //     if (in_array($item['type'], [2,4,5]) && $item['prev_children_balance'] < 0) {
                        //         $prev_debit = number_format(abs($item['prev_children_balance']), 2);
                        //     }
                        // } else if (isset($item['prev_children_balance']) && $item['prev_children_balance'] == 0) {
                        //     $prev_debit = !empty($item['prev_debit']) ? $item['prev_debit'] : '';
                        //     $prev_credit = !empty($item['prev_credit']) ? $item['prev_credit'] : '';
                        // }
                    @endphp
                    @if ($item['view_in_trial'] == 1)
                    @php
                        if (is_numeric(str_replace(',','',$debit))) {
                            $total_dr += str_replace(',','',$debit);
                        }
                        if (is_numeric(str_replace(',','',$credit))) {
                            $total_cr += str_replace(',','',$credit);
                        }
                        // if (is_numeric(str_replace(',','',$prev_debit))) {
                        //     $total_dr_prev += str_replace(',','',$prev_debit);
                        // }
                        // if (is_numeric(str_replace(',','',$prev_credit))) {
                        //     $total_cr_prev += str_replace(',','',$prev_credit);
                        // }
                    @endphp
                        <tr>
                            <td class="tabspace-{{$item['level']}}" style="text-align: left;"><a target="_blank" style="z-index: 10; position: relative;" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                            <td>{{$k > 0 ? $item['code'] : ""}}</td>
                            <td class="text-right nowrap">{{$debit}}</td>
                            <td class="text-right nowrap">{{$credit}}</td>
                            {{-- <td class="text-right nowrap">{{$prev_debit}}</td>
                            <td class="text-right nowrap">{{$prev_credit}}</td> --}}
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="fw-bold" colspan="2" style="text-align: right;">Total</td>
                    <td class="text-right nowrap">{{number_format($total_dr,2)}}</td>
                    <td class="text-right nowrap">{{number_format($total_cr,2)}}</td>
                    {{-- <td class="text-right nowrap">{{number_format($total_dr_prev,2)}}</td>
                    <td class="text-right nowrap">{{number_format($total_cr_prev,2)}}</td> --}}
                </tr>
            @endif
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