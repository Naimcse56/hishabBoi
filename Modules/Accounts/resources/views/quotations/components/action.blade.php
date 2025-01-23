<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{route('quotations.show',encrypt($row->id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
    @if ($row->is_approved != 'Approved')
        <a href="{{route('quotations.edit',encrypt($row->id))}}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
        <button type="button" onclick="deleteData('Quotation', '{{ route('quotations.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
            <i class="fa fa-trash"></i>
        </button>
    @endif
    @if ($row->is_approved == 'Approved' && $row->sale()->count() == 0)
        <a href="{{route('quotations.convert_to_sale',encrypt($row->id))}}" class="btn btn-sm btn-warning">Conver to Sale</a>
    @endif
    @if ($row->sale()->count() > 0)
        <a href="{{route('sales.show',encrypt($row->sale->id))}}" class="btn btn-sm btn-secondary">{{$row->sale->invoice_no}}</a>
    @endif
</div>