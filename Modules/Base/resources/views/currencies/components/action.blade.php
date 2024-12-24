<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-warning edit_leadger" data-id="{{ encrypt($row->id) }}"><i class="fa fa-edit"></i>
    </button>
    <button type="button" onclick="deleteData('Currency ', '{{ route('currencies.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
        <i class="fa fa-trash"></i>
    </button>
</div>