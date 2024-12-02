@extends('layouts.admin_app')
@section('title')
Multi Cash Payment Voucher
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Cash Payment Vouchers List</h4></div>
            <div><a href="{{route('multi-cash-payment.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Date</th>
                                    <th>TXN ID</th>
                                    <th>Narration</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table></div>
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

            $(document).ready(function(){
                var table = $('#dataTable').DataTable( {
					processing: true,
					serverSide: true,
					ajax: "{{ route('multi-cash-payment.index') }}",
					columns: [
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
						{data: 'date', name: 'date'},
						{data: 'txn_id', name: 'txn_id'},
						{data: 'narration', name: 'narration'},
						{data: 'amount', name: 'amount'},
						{data: 'status', name: 'status', orderable: false, searchable: false},
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
                        $('#detail_info_modal').modal('show');
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
