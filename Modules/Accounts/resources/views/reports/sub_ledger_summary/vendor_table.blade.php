

<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th colspan="7" class="text-center sky-bg">
                <h5 class="mb-2">{{ app('general_setting')['company_name'] }}</h5>
                <h6 class="mb-2">{{ app('general_setting')['company_address']}}</h6>
                <h6 class="mb-0">{{ucwords(request('type'))}} Summary Report</h6>
            </th>
        </tr>
        <tr>
            <th colspan="7" class="text-center">Date Range: {{date('d, F - Y', strtotime($dateFrom)).' to '.date('d, F - Y', strtotime($dateTo))}}</th>
        </tr>
        <tr>
            <th scope="col" width="4%">Sl No.</th>
            <th scope="col" class="text-center">Date</th>
            <th scope="col" class="text-center">TXN ID</th>
            <th scope="col" class="text-center">Narration</th>
            <th scope="col" class="text-center" width="10%">Debit</th>
            <th scope="col" class="text-center" width="10%">Credit</th>
            <th scope="col" class="text-center" width="10%">Current Balance</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($reports->groupBy('sub_ledger_type') as $member_type => $report_item)
            <tr>
                <td class="fw-semibold" colspan="10">
                    {{$member_type}}
                </td>
            </tr>
            @foreach ($report_item as $key => $report)
                @php
                    $total_dr = 0;
                    $total_cr = 0;
                @endphp
                <tr>
                    <td class="fw-semibold tabspace-2" colspan="7">{{$report['name']}}</td>
                </tr>
                <tr>
                    <td colspan="6">Opening Balance</td>
                    <td class="text-right nowrap">{{number_format($report['opening_balance'], 2)}}</td>
                </tr>
                @php
                    $currentBalance = 0 + $report['opening_balance'];
                @endphp
                @foreach ($report['transaction_data'] as $sl => $item)
                    @php
                        $currentBalance = $item['type'] == "Cr" ? ($currentBalance + $item['amount']) :  ($currentBalance - $item['amount']);
                    @endphp
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{$item['date']}}</td>
                        <td><a href="javascript:;" class="detail_info text-black" data-route="{{ route('journal.show',encrypt($item['voucher_id'])) }}">{{  @$item['txn_id'] }}</a></td>
                        <td>
                            Particular: {{$item['narration']}} <br>
                        </td>
                        <td class="text-right nowrap">
                            @if ($item['type'] == "Dr")
                                @php
                                    $total_dr += $item['amount'];
                                @endphp
                                {{number_format($item['amount'], 2)}}
                            @endif
                        </td>
                        <td class="text-right nowrap">
                            @if ($item['type'] == "Cr")
                                @php
                                    $total_cr += $item['amount'];
                                @endphp
                                {{number_format($item['amount'], 2)}}
                            @endif
                        </td>
                        <td class="text-right nowrap">{{number_format($currentBalance, 2)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right nowrap">{{number_format($total_dr, 2)}}</td>
                    <td class="text-right nowrap">{{number_format($total_cr, 2)}}</td>
                    <td class="text-right nowrap"></td>
                </tr>
            @endforeach
            <tr>
                <td class="fw-semibold" colspan="7"></td>
            </tr>
        @endforeach
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