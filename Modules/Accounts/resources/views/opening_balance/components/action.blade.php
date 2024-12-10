<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-route="{{ route('opening-balance.show',encrypt($row->id)) }}"><i class="fa fa-eye"></i></button>
    @if ($row->is_approve != 1)
    <a href="{{ route('opening-balance.edit',encrypt($row->id)) }}" class="btn btn-sm btn-warning edit_leadger"><i class="fa fa-edit"></i></a>
    <button type="button" onclick="deleteData('Opening Balance', '{{ route('opening-balance.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
        <i class="fa fa-trash"></i>
    </button>
    @endif
</div>