@extends('layouts.admin_app')
@section('title')
Ledger Accounts
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Ledger Accounts</h4></div>
            <div><a href="{{route('ledger.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Type</th>
                                    <th>Code</th>
                                    <th>AC Name</th>
                                    <th>Status</th>
                                    <th>Current Balance</th>
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
        <div id="ajaxDiv"></div>
    </div>

@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $(document).ready(function(){
                var table = $('#dataTable').DataTable( {
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('ledger.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'type', name: 'type'},
                        {data: 'code', name: 'code'},
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'},
                        {data: 'amount', name: 'amount', className:'text-right'},
                        {data: 'action', name: 'action', orderable: false, searchable: false, printable:false},
                    ],
                    responsive: false,
                    lengthChange: true,
                } );
                $.fn.dataTable.ext.errMode = () => alert('Error while loading the table data. Please refresh');
            });

            $(document).on('click','.detail_info', function(){
                let url = APP_URL + "/accountings/ledger/show/"+$(this).data("id");

                $.get(url, function(data){
                    $('#ajaxDiv').html(data);
                    $('#showModal').modal('show');
                });
            });
        })(jQuery);
    </script>
@endpush
