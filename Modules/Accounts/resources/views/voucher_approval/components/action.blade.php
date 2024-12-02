
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-sm btn-outline-info detail_info" data-route="{{ route('voucher.show',encrypt($row->id)) }}"><i class="bx bx-show"></i>
    </button>
    <button type="button" onclick="deleteData('Payment Voucher', '{{ route('voucher.delete') }}', {{ $row->id }})" class="btn btn-sm btn-outline-danger" id="basicAlert">
        <i class="bx bx-trash"></i>
    </button>
</div>