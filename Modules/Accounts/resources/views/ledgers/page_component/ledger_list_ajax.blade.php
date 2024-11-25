@foreach ($ChartOfAccountList as $charAccount)
    <tr>
        <td>{{ $charAccount->TypeName }}</td>
        <td>{{ $charAccount->code }}</td>
        <td>
            @for ($i = 0; $i < $charAccount->level; $i++)
                <strong>-</strong>
            @endfor
            <strong>-></strong>
            @if ($charAccount->is_cost_center == 0)
                <a href="javascript:;" target="_blank">{{ $charAccount->name }}</a>
            @else
                {{ $charAccount->name }}
            @endif
        </td>
        <td>{{ $charAccount->is_cost_center  == 1 ? "Yes" : "No" }}</td>
        <td>
            @if($charAccount->is_active == 1)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">InActive</span>
            @endif
        </td>
        <td>{{currencySymbol( $charAccount->BalanceAmount )}}</td>
        <td>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-sm btn-outline-warning edit_leadger" data-id="{{ encrypt($charAccount->id) }}"><i class="bx bx-pencil"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-info detail_info" data-id="{{ encrypt($charAccount->id) }}"><i class="bx bx-show"></i>
                </button>
                <button type="button" onclick="deleteData('Chart of Account', '{{ route('ledger.delete') }}', {{ $charAccount->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
                    <i class="bx bx-trash"></i>
                </button>
            </div>
        </td>
    </tr>

    @foreach ($charAccount->childrenCategories as $child_account)
        @include('accounts::ledgers.page_component.child_ledger_list', ['child_account' => $child_account])
    @endforeach
@endforeach
