<tr>
    <td>{{ $child_account->TypeName }}</td>
    <td>{{ $child_account->code }}</td>
    <td>
        @for ($i = 0; $i < $child_account->level; $i++)
            <strong>-</strong>
        @endfor
        <strong>></strong>
        @if ($child_account->is_cost_center == 0)
            <a href="javascript:;" target="_blank">{{ $child_account->name }}</a>
        @else
            {{ $child_account->name }}
        @endif
    </td>
    <td>{{ $child_account->is_cost_center == 1 ? "Yes" : "No" }}</td>
    <td>
        @if($child_account->is_active == 1)
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">InActive</span>
        @endif
    </td>
    <td>{{currencySymbol( $child_account->BalanceAmount )}}</td>
    <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-sm btn-outline-warning edit_leadger" data-id="{{ encrypt($child_account->id) }}"><i class="bx bx-pencil"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-info detail_info" data-id="{{ encrypt($child_account->id) }}"><i class="bx bx-show"></i>
            </button>
            <button type="button" onclick="deleteData('Chart of Account', '{{ route('ledger.delete') }}', {{ $child_account->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
                <i class="bx bx-trash"></i>
            </button>
        </div>
    </td>
</tr>
@if ($child_account->categories)
    @foreach ($child_account->categories as $child_account)
        @include('accounts::ledgers.page_component.child_ledger_list', ['child_account' => $child_account])
    @endforeach
@endif
