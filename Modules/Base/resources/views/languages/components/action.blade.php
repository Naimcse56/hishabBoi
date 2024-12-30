<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-warning edit_leadger" data-id="{{ encrypt($row->id) }}"><i class="fa fa-edit"></i>
    </button>
    @if ($row->id > 3)
        <button type="button" onclick="deleteData('Language ', '{{ route('language.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>