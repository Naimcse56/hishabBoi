<table class="table table_modal table-bordered">
    @php
        $total_debit = 0;
        $total_credit = 0;
    @endphp
    <thead>
        <tr>
            <th scope="col" width="30%">Ledger</th>
            <th scope="col">Party</th>
            <th scope="col" width="15%">Debit (BDT)</th>
            <th scope="col" width="15%">Credit (BDT)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($row->transactions as $item)
            @php
                if ($item->type == "Dr") {
                    $total_debit += $item->amount;
                } else {
                    $total_credit += $item->amount;
                }
            @endphp
            <tr>
                <td>{{ $item->ledger->name }} ({{ $item->ledger->code }})</a></td>
                <td>
                    {{ $item->sub_ledger->name }}
                    @if ($item->work_order_id)
                        <p class="mb-0 font-13">Work Order : {{ $item->work_order->order_name }}</p>
                        <p class="mb-0 font-13">Work Order No : {{ $item->work_order->order_no }}</p>
                        <p class="mb-0 font-13">Work Order Site : {{ $item->work_order_site_detail->site_name }}</p>
                    @endif
                    @if ($item->check_no || $item->bank_name || $item->bank_account_name)
                        <p class="mb-0 font-13">Bank Name : {{$item->bank_name}}</p>
                        <p class="mb-0 font-13">Bank Account Name : {{$item->bank_account_name}}</p>
                        <p class="mb-0 font-13">Cheque No : {{$item->check_no}}</p>
                        <p class="mb-0 font-13">Cheque Maturity Date : {{$item->check_mature_date}}</p>
                    @endif
                    @if ($item->narration && $row->panel == "cash_payment_multiple")
                     <p class="mb-0 font-13">Purpose : {{$item->narration}}</p>
                    @endif
                </td>
                <td>
                    {{ ($item->type == "Dr") ? number_format($item->amount, 2) : "" }}
                </td>
                <td>
                    {{ ($item->type == "Cr") ? number_format($item->amount, 2) : "" }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Total Amount</td>
            <td class="nowrap" id="total_debit"> {{ number_format($total_debit, 2) }}</td>
            <td class="nowrap" id="total_credit"> {{ number_format($total_credit, 2) }}</td>
        </tr>
        <tr>
                <td>Taka In&nbsp;Words:&nbsp;</td>
                <td colspan="3">{{convert_number($row->amount)}}          &nbsp;Only</td>
        </tr>
        <tr>
                <td>Narration</td>
                <td colspan="3">{{$row->narration}}</td>
        </tr>
        <tr>
                <td>Concern Person</td>
                <td colspan="3">{{$row->concern_person}}</td>
        </tr>
    </tbody>
</table>