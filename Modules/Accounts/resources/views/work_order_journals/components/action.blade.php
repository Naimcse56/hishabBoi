<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-route="{{ route('journal.work_order.show',encrypt($row->id)) }}"><i class="fa fa-eye"></i></button>
    @if ($row->is_approve != 1)
    <a href="{{ route('journal.work_order.edit',encrypt($row->id)) }}" class="btn btn-sm btn-warning edit_leadger"><i class="fa fa-edit"></i></a>
    <button type="button" onclick="deleteData('W/O Journal', '{{ route('journal.work_order.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
        <i class="fa fa-trash"></i>
    </button>
    @endif
</div>