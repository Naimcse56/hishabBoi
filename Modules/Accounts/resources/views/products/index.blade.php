@extends('layouts.admin_app')
@section('title')
Products List
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Products List</h4></div>
            <div><a href="{{route('products.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New Product</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered data-table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Sell. Price (BDT)</th>
                                        <th>Purchase. Price (BDT)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
                    ajax: "{{ route('products.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'type', name: 'type'},
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'},
                        {data: 'selling_price', name: 'selling_price', className:'text-right'},
                        {data: 'purchase_price', name: 'purchase_price', className:'text-right'},
                        {data: 'action', name: 'action', orderable: false, searchable: false, printable:false},
                    ],
                    responsive: false,
                    lengthChange: true,
                } );
                $.fn.dataTable.ext.errMode = () => alert('Error while loading the table data. Please refresh');
            });

            $(document).on('click','.detail_info', function(){
                let url = APP_URL + "/accountings/products/show/"+$(this).data("id");

                $.get(url, function(data){
                    $('#ajaxDiv').html(data);
                    $('#showModal').modal('show');
                });
            });
        })(jQuery);
    </script>
@endpush
