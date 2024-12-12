<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('sales.print',encrypt($row->id))}}" class="btn btn-sm btn-secondary"><i class="fa fa-print"></i></a>
    <a href="{{route('sales.show',encrypt($row->id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
    <a href="{{route('sales.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
    @if ($row->is_approved != 'Approved')
        <button type="button" onclick="deleteData('Sale', '{{ route('sales.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>