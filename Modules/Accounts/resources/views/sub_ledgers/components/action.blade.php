<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('sub-ledger.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>
    <button type="button" class="btn btn-sm btn-outline-info detail_info" data-route="{{ route('sub-ledger.show',encrypt($row->id)) }}"><i class="bx bx-show"></i>
    </button>
    <button type="button" onclick="deleteData('Party Account', '{{ route('sub-ledger.delete') }}', {{ $row->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
        <i class="bx bx-trash"></i>
    </button>
</div>