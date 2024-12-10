
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-info detail_info" data-route="{{ route('voucher.show',encrypt($row->id)) }}"><i class="fa fa-eye"></i>
    </button>
    <button type="button" onclick="deleteData('Voucher', '{{ route('voucher.delete') }}', {{ $row->id }})" class="btn btn-sm btn-danger" id="basicAlert">
        <i class="fa fa-trash"></i>
    </button>
</div>