<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('quotations.show',encrypt($row->id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
    @if ($row->is_approved != 'Approved')
        <a href="{{route('quotations.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <button type="button" onclick="deleteData('Quotation', '{{ route('quotations.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>