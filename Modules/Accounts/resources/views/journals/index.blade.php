@extends('layouts.admin_app')
@section('title')
General Journal List
@endsection
@section('content')
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Accounts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('journal.index')}}"><i class="bx bx-line-chart-down"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">General Journal List</li>
                    </ol>
                </nav>
            </div>
            
            <div class="ms-auto">
                <a href="{{route('journal.create')}}" class="btn btn-primary"><i class="bx bx-plus"></i>Add New</a>
            </div>
        </div>
        <!--end breadcrumb-->
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
					ajax: "{{ route('journal.index') }}",
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
                
				// $('#dataTable').DataTable({
				// 	processing: true,
				// 	serverSide: true,
				// 	ajax: "{{ route('journal.index') }}",
                //     dom:'lBfrtip',
				// 	columns: [
				// 		{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				// 		{data: 'date', name: 'date'},
				// 		{data: 'txn_id', name: 'txn_id'},
				// 		{data: 'narration', name: 'narration'},
				// 		{data: 'amount', name: 'amount'},
				// 		{data: 'action', name: 'action', orderable: false, searchable: false},
				// 	],
                //     responsive: false,
                //     lengthChange: false,
                //     buttons: [ 'copy', 'excel', 'pdf', 'print']
				// }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');

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