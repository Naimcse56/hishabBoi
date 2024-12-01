<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('work-order.edit',encrypt($row->id)) }}" class="btn btn-sm btn-outline-warning edit_leadger"><i class="bx bx-pencil"></i>
    </a>
    <button type="button" class="btn btn-sm btn-outline-info detail_info" data-route="{{ route('work-order.show',encrypt($row->id)) }}"><i class="bx bx-show"></i>
    </button>
    @if ($row->transactions()->count() == 0)
    <button type="button" onclick="deleteData('Work Order', '{{ route('work-order.delete') }}', {{ $row->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
        <i class="bx bx-trash"></i>
    </button>
    @endif
</div>