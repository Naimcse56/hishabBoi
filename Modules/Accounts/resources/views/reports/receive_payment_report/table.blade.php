@php
    $total_direct_income = 0;
    $total_direct_expense = 0;
    $total_tax_expense = 0;
@endphp
<table class="table table-bordered mb-0" style="width:100%">
    <thead>
        <tr>
            <th colspan="6" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-0">Receipt And Payment Report</h6>
            </th>
        </tr>
        <tr>
            <th colspan="6" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</th>
        </tr>
        <tr>
            <th colspan="3" width="50%">Receipt</th>
            <th colspan="3" width="50%">Payment</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_rcv = 0;
            $total_bank_rcv = 0;
            $total_pay = 0;
            $total_bank_pay = 0;
        @endphp
        <tr>
            <td colspan="3">
                <table class="table table-bordered mb-0" style="width:100%">
                    <tbody>
                        @foreach ($transactions as $key => $transaction)
                            @if ($transaction->sum('rcv_balance') || $transaction->sum('rcv_bank_balance') > 0)
                                <tr>
                                    <td class="fw-semibold">{{$key}}</td>
                                    <td class="fw-semibold">Cash</td>
                                    <td class="fw-semibold">Bank</td>
                                </tr>
                            @endif
                            @foreach ($transaction->filter(function ($tran) {
                                        return $tran['rcv_balance'] > 0 || $tran['rcv_bank_balance'] > 0;
                                    }) as $i => $item)
                                @php
                                    $total_rcv += $item['rcv_balance'];
                                    $total_bank_rcv += $item['rcv_bank_balance'];
                                @endphp
                                <tr>
                                    <td class="pl-25"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                                    <td class="nowrap text-right" width="20%"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'reciept_payment' => 'rcv_cash'])}}">{{number_format($item['rcv_balance'],2)}}</a></td>
                                    <td class="nowrap text-right" width="20%"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'reciept_payment' => 'rcv_bank'])}}">{{number_format($item['rcv_bank_balance'],2)}}</a></td>
                                </tr>
                            @endforeach
                            @if ($transaction->sum('rcv_balance') > 0 || $transaction->sum('rcv_bank_balance') > 0)
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right fw-semibold">{{number_format($transaction->sum('rcv_balance'),2)}}</td>
                                    <td class="text-right fw-semibold">{{number_format($transaction->sum('rcv_bank_balance'),2)}}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Grand Total</td>
                            <td class="fw-semibold text-right">{{number_format($total_rcv,2)}}</td>
                            <td class="fw-semibold text-right">{{number_format($total_bank_rcv,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td colspan="3">
                <table class="table table-bordered mb-0" style="width:100%">
                    <tbody>
                        @foreach ($transactions as $key => $transaction)
                            @if ($transaction->sum('pay_balance') || $transaction->sum('pay_bank_balance') > 0)
                                <tr>
                                    <td class="fw-semibold">{{$key}}</td>
                                    <td class="fw-semibold">Cash</td>
                                    <td class="fw-semibold">Bank</td>
                                </tr>
                            @endif
                            @foreach ($transaction->filter(function ($tran) {
                                        return $tran['pay_balance'] > 0 || $tran['pay_bank_balance'] > 0;
                                    }) as $j => $item)
                                @php
                                    $total_pay += $item['pay_balance'];
                                    $total_bank_pay += $item['pay_bank_balance'];
                                @endphp
                                <tr>
                                <td class="pl-25"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id']])}}">{{$item['name']}}</a></td>
                                <td class="nowrap text-right" width="20%"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'reciept_payment' => 'pay_cash'])}}">{{number_format($item['pay_balance'],2)}}</a></td>
                                <td class="nowrap text-right" width="20%"><a target="_blank" class="text-black" href="{{route('accountings.ledger_report_details_specific_filter',['start_date' => $dateFrom, 'end_date' => $dateTo, 'account_id' => $item['id'], 'reciept_payment' => 'pay_bank'])}}">{{number_format($item['pay_bank_balance'],2)}}</a></td>
                                </tr>
                            @endforeach
                            @if ($transaction->sum('pay_balance') > 0 || $transaction->sum('pay_bank_balance') > 0)
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right fw-semibold">{{number_format($transaction->sum('pay_balance'),2)}}</td>
                                    <td class="text-right fw-semibold">{{number_format($transaction->sum('pay_bank_balance'),2)}}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Grand Total</td>
                            <td class="fw-semibold text-right">{{number_format($total_pay,2)}}</td>
                            <td class="fw-semibold text-right">{{number_format($total_bank_pay,2)}}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        
    </tbody>
    @if (strpos($_SERVER['REQUEST_URI'], 'print') == true)
    <tfoot>
        <tr>
            <td colspan="6">
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