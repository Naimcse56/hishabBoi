@extends('layouts.admin_app')
@section('title')
Cash Book
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <h4 class="mt-4">Cash Book</h4>
            <div>
                <a href="javascript:;" class="btn btn-info filter_by"><i class="bx bx-filter-alt"></i></a>
                <a href="{{strpos($_SERVER['REQUEST_URI'], '?') == true ? Illuminate\Support\Facades\Request::fullUrl().'&print=1' : Illuminate\Support\Facades\Request::fullUrl().'?print=1' }}" class="btn btn-warning" target="_blank"><i class="bx bx-printer"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 filter_div @isset($transactions) d-none @endisset">
                <div class="card">
                    <div class="card-body">
                        <form class="form" method="GET" action="{{route('accountings.cashbook')}}">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Select Cash Account <span class="text-danger">*</span></label>
                                    <select class="form-select debit_account_id" name="bank_id" id="bank_id" required>
                                        @isset($filtered_account)
                                            <option value="{{$filtered_account->id}}">{{$filtered_account->name}}</option>
                                        @else
                                            <option value="0">Select An Account</option>
                                        @endisset
                                    </select>
                                    <span class="text-danger" id="bank_id_error"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">From Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="start_date" id="start_date" value="{{request('start_date') ? request('start_date') : date('d/m/Y', strtotime(app('day_closing_info')->from_date))}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">To Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control date" name="end_date" id="end_date" value="{{request('end_date') ? request('end_date') : date('d/m/Y')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Select Type <span class="text-danger">*</span></label>
                                    <select class="form-select main_select_2" name="type" id="type" required>
                                        <option value="member" @selected(request('type') == "member")>Member</option>
                                        <option value="customer" @selected(request('type') == "customer")>Client</option>
                                        <option value="supplier" @selected(request('type') == "supplier")>Supplier</option>
                                    </select>
                                    <span class="text-danger" id="account_id_error"></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="">Select Party A/C</label>
                                    <select class="form-select party_id" name="party_id" id="party_id" required>
                                        @isset($party)
                                            <option value="{{$party->id}}">{{$party->name}}</option>
                                        @else
                                            <option value="0">Select An Account</option>
                                        @endisset
                                    </select>
                                    <span class="text-danger" id="party_id_error"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-search"></i>Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    @isset($transactions)
                        <div class="card-body">
                            @include('accounts::reports.cashbook.table')
                        </div>
                    @endisset
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
            $(document).on('click', '.filter_by', function(e){
                if ($('.filter_div').hasClass('d-none')) {
                    $('.filter_div').removeClass('d-none')
                }else{
                    $('.filter_div').addClass('d-none')
                }
            });
            
            $(".debit_account_id").select2({
                ajax: {
                    url: '{{route('ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: "cash",
                                view: 'ledger'
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
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
            $(".party_id").select2({
                ajax: {
                    url: '{{route('sub-ledger.transactional_list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                                type: $('#type').val(),
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
        })(jQuery);
    </script>
@endpush