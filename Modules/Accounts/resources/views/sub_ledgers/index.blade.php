@extends('layouts.admin_app')
@section('title')
Party Accounts
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Party Accounts List</h4></div>
        <div><a href="{{route('sub-ledger.create')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> Add New</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered data-table">
                        <thead>
                            <tr>
                                <th width="4%">#</th>
                                <th>Party Type</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Code</th>
                                <th>TIN</th>
                                <th>Is Active</th>
                                <th width="10%">Action</th>
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
        @if (Route::is('sub-ledger.index'))
            <input type="hidden" id="current_route" value="{{route('sub-ledger.index')}}">
        @elseif(Route::is('sub-ledger.customer_index'))
            <input type="hidden" id="current_route" value="{{route('sub-ledger.customer_index')}}">
        @else
            <input type="hidden" id="current_route" value="{{route('sub-ledger.member_index')}}">
        @endif
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': APP_TOKEN
                    }
                });
                var table = $('#dataTable').DataTable( {
					processing: true,
					serverSide: true,
					ajax: $('#current_route').val(),
					columns: [
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
						{data: 'sub_ledger_type.name', name: 'sub_ledger_type.name'},
						{data: 'name', name: 'name'},
						{data: 'email', name: 'email'},
						{data: 'code', name: 'code'},
						{data: 'tin', name: 'tin'},
						{data: 'is_active', name: 'is_active'},
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