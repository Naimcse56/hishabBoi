@extends('layouts.admin_app')
@section('title')
Vouchers Checking
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Vouchers Checking List</h4>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control amount" name="amount" id="amount" value="" placeholder="Search with Amount">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered data-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10%">TXN ID</th>
                                        <th width="60%">Details</th>
                                        <th>Status</th>
                                        <th width="4%"><input type="checkbox" class="form-check-input select_all_voucher_ids bg-primary" name="select_all"/></th>
                                        <th>Rejection Comment</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex">   
                        <button type="button" onclick="approveMultipleVoucherData('Voucher Approval', '{{ route('voucher.multiple_approve_now') }}', 'reject')" class="btn btn-sm btn-outline-danger w-50">
                            <i class="lni lni-close"></i> Reject
                        </button>                 
                        <button type="button" onclick="approveMultipleVoucherData('Voucher Approval', '{{ route('voucher.multiple_approve_now') }}', 'approve')" class="btn btn-sm btn-success w-50">
                            <i class="lni lni-checkmark"></i> Approve
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="ajaxDiv"></div>
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;

            $(document).on('click','.select_all_voucher_ids', function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#amount').on('change',function(){
                $('#dataTable').DataTable().ajax.reload();
            });
            $(document).ready(function(){
                var table = $('#dataTable').DataTable( {
					processing: true,
					serverSide: true,
					// ajax: "{{ route('voucher.approval_index') }}",
                    'ajax': {
                        url: "{{ route('voucher.approval_index') }}",
                        "data": function (d) {
                            return $.extend({}, d, {
                                "amount": $('#amount').val()
                            });
                        }
                    },
					columns: [
						// {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
						{data: 'txn_id', name: 'txn_id'},
						{data: 'details', name: 'details'},
						{data: 'status', name: 'status', searchable: false},
						{data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
						{data: 'comment', name: 'comment', searchable: false},
						{data: 'action', name: 'action', orderable: false, searchable: false, printable:false},
					],
                    responsive: false,
                    lengthChange: true,
                } );
                $.fn.dataTable.ext.errMode = () => alert('Error while loading the table data. Please refresh');
            });
            $(document).on('click','.detail_info', function(){
                $('.detail_info').addClass('disabled');
                var url = $(this).attr("data-route");
                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "HTML",
                    success: function (response) {
                        $('#ajaxDiv').html(response);
                        $('#voucher_info_modal').modal('show');
                        $('.detail_info').removeClass('disabled');
                    },
                    error: function (error) {
                        $('.detail_info').removeClass('disabled');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
