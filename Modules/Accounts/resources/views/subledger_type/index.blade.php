@extends('layouts.admin_app')
@section('title')
Party Type List
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Party Type List</h4></div>
            <div><button type="button" class="btn btn-sm btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#exampleLargeModal"><i class="fa fa-plus"></i> Add New</button></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-bordered data-table">
                            <thead>
                                <tr>
                                    <th width="4%">#</th>
                                    <th>Name</th>
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
    @include('accounts::subledger_type.create')

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
					ajax: "{{ route('subledger-type.index') }}",
					columns: [
						{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
						{data: 'name', name: 'name'},
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

            $(document).on('click','.edit_leadger', function(){
                let url = APP_URL + "/accountings/type-wise-party-account/edit/"+$(this).data("id");
                
                $.get(url, function(data){
                    $('#ajaxDiv').html(data);
                    $('#editModal').modal('show');
                });
            });
            $(document).on("click", ".save-btn", function (event) {
                $('.save-btn').prop('disabled', true);
                event.preventDefault();
                let formData = $('#chart_account_form').serializeArray();
                $.ajax({
                    url: APP_URL + "/accountings/type-wise-party-account/store",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $('.save-btn').prop('disabled', false);
                        $("#exampleLargeModal").modal("hide");
                        $("#chart_account_form").trigger("reset");
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function (error) {
                        $('.save-btn').prop('disabled', false);
                        toastr.warning("Something went wrong!");
                        if (error) {
                            $.each(error.responseJSON.errors, function (key, message) {
                                $("#" + key + "_error").html(message[0]);
                            });
                        }
                    }

                });
            });
        })(jQuery);
    </script>
@endpush