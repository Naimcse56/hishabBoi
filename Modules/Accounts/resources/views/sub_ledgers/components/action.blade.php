
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-route="{{ route('sub-ledger.show',encrypt($row->id)) }}"><i class="fa fa-eye"></i></button>
    <a href="{{route('sub-ledger.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>
    </a>
    @if ($row->is_blocked != 1)
        <button type="button" onclick="deleteData('Party Account', '{{ route('sub-ledger.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>