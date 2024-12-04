<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-outline-info detail_info" data-route="{{ route('journal.show',encrypt($row->id)) }}"><i class="bx bx-show"></i>
    </button>
    @if ($row->is_approve != 1)
    <a href="{{route('journal.edit',encrypt($row->id))}}" class="btn btn-sm btn-outline-warning edit_leadger"><i class="bx bx-pencil"></i>
    </a>
    <button type="button" onclick="deleteData('Journal', '{{ route('journal.delete') }}', {{ $row->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
        <i class="bx bx-trash"></i>
    </button>        
    @endif
</div>