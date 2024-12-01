<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-route="{{ route('work-order.show',encrypt($row->id)) }}"><i class="fa fa-eye"></i></button>
    <a href="{{ route('work-order.edit',encrypt($row->id)) }}" class="btn btn-sm btn-warning edit_leadger"><i class="fa fa-edit"></i></a>
    @if ($row->transactions()->count() == 0)
    <button type="button" onclick="deleteData('Work Order', '{{ route('work-order.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
        <i class="fa fa-trash"></i>
    </button>
    @endif
</div>