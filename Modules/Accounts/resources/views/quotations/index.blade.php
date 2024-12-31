@extends('layouts.admin_app')
@section('title')
Quotation List
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Quotation List</h4></div>
            <div><a href="{{route('quotations.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New Quotation</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Client</th>
                                    <th>Phone</th>
                                    <th>Total Payable</th>
                                    <th>Status</th>
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
                    ajax: "{{ route('quotations.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'date', name: 'date'},
                        {data: 'invoice_no', name: 'invoice_no'},
                        {data: 'sub_ledger.name', name: 'sub_ledger.name'},
                        {data: 'phone', name: 'phone'},
                        {data: 'payable_amount', name: 'payable_amount', className:'text-right'},
                        {data: 'is_approved', name: 'is_approved'},
                        {data: 'action', name: 'action', orderable: false, searchable: false, printable:false},
                    ],
                    responsive: false,
                    lengthChange: true,
                } );
                $.fn.dataTable.ext.errMode = () => alert('Error while loading the table data. Please refresh');
            });
        })(jQuery);
    </script>
@endpush
