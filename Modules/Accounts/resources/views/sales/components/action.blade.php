<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-id="{{ encrypt($row->id) }}"><i class="fa fa-eye"></i></button>
    <a href="{{route('products.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i>
    </a>
    @if ($row->is_blocked != 1)
        <button type="button" onclick="deleteData('Product', '{{ route('products.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>