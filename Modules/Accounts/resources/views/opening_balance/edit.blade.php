@extends('layouts.admin_app')
@section('title')
Opening Balance Edit
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">Edit Opening Balance</h4></div>
        <div><a href="{{route('opening-balance.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> List</a></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="journal_update_form" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control date" name="date" id="date" value="{{ date('d/m/Y', strtotime($journal->date)) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="">Journal type <span class="text-danger">*</span></label>
                                <select class="form-select journal_type" name="journal_type" id="journal_type" required>
                                    <option value="others" @selected($journal->type == "others")>Others</option>
                                    <option value="rcv" @selected($journal->type == "rcv")>Receive</option>
                                    <option value="pay" @selected($journal->type == "pay")>Payment</option>
                                </select>
                                <span class="text-danger" id="journal_type_error"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="Concern Person" class="form-label">Concern Person</label>
                                <input type="text" class="form-control" name="concern_person" placeholder="Concern Person" value="{{$journal->concern_person}}">
                                <span class="text-danger">{{$errors->first('concern_person')}}</span>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Narration</label>
                                <textarea class="form-control" id="narration" name="narration_voucher" placeholder="Narration ..." rows="3">{{$journal->narration}}</textarea>
                            </div>
                        </div>
                        <input type="hidden" id="rowId" value="{{$journal->id}}">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend">Journal Details Information</legend>
                            <div class="entry_row_div">
                                @foreach ($journal->transactions as $key => $transaction)
                                    <div class="row new_added_row">                                    
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="">Ledger Accounts <span class="text-danger">*</span></label>
                                            <select class="form-select account_id" name="account_id[]" data-row="{{ $key+1 }}" required>
                                                <option value="{{$transaction->ledger_id}}" selected>{{$transaction->ledger->code}} ({{$transaction->ledger->name}})</option>
                                            </select>
                                            <span class="text-danger" id="_error"></span>
                                        </div>                                   
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="">Party Accounts <span class="text-danger">*</span></label>
                                            <select class="form-select sub_account_id" name="sub_account_id[]" required>
                                                @if ($transaction->sub_ledger_id > 0)
                                                    <option value="{{$transaction->sub_ledger_id}}" selected>{{$transaction->sub_ledger->code}} ({{$transaction->sub_ledger->name}})</option>
                                                @else
                                                    <option value="0">Select One</option>
                                                @endif
                                            </select>
                                            <span class="text-danger" id="_error"></span>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="Narration" class="form-label">Debit <span class="text-danger">*</span></label>
                                            <input type="number" min="0" step="0.0000001" class="form-control debit_amount" name="debit_amount[]" placeholder="0" value="{{ ($transaction->type == "Dr") ? $transaction->amount : 0}}" required>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="Narration" class="form-label">Credit <span class="text-danger">*</span></label>
                                            <input type="number" min="0" step="0.0000001" class="form-control credit_amount" name="credit_amount[]" placeholder="0" value="{{ ($transaction->type == "Cr") ? $transaction->amount : 0}}" required>
                                            <span class="text-danger"></span>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <div class="d-block">
                                                <label class="form-label" for=""> Action </label>
                                                <div>
                                                    <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-4 text-right">
                                <label class="form-label" for="Total Amount">Total Amount (BDT) :</label>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="primary_input mb-15 d-block">
                                    <label class="form-label total_debit_amount" for="Dr Amount">{{$journal->amount}}</label>
                                </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="primary_input mb-15 d-block">
                                    <label class="form-label total_credit_amount" for="Cr Amount">{{$journal->amount}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ms-auto">
                                    <a href="javascript:;" class="btn btn-sm btn-primary" id="add_new_line">Add New Row</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary save-btn "><i class="bx bx-check-double"></i>Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="ajaxDiv"></div>
    <input type="hidden" value="{{route('ledger.transactional_list_for_select')}}" id="ledger_list_select_option">
    <input type="hidden" value="{{ route("journal.add_new_line") }}" id="add_new_entry">
    <input type="hidden" value="{{route('opening-balance.update', encrypt($journal->id))}}" id="journal_update_url">
    </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN; 
            var row = (parseInt($('.new_added_row').length) > 0) ? parseInt($('.new_added_row').length) : 1;
            var inputTimeout;

            $(document).ready(function(){
                getMainAccount();
                getPartners();
            });

            $(document).on('focus', '.debit_amount,.credit_amount', function(e){
                e.preventDefault();
                $(this).val("");
            });

            $(document).on('focusout', '.debit_amount,.credit_amount', function(e){
                e.preventDefault();
                if (!$.isNumeric($(this).val())) {
                    $(this).val(0);
                }
            });

            $(document).on('click', '#add_new_line', function(e){
                e.preventDefault();
                row += 1;
                $.ajax({
                    url: $('#add_new_entry').val(),
                    type: "GET",
                    dataType: "JSON",
                    data: {row:row},
                    success: function (response) {
                        $(".entry_row_div").append(response);
                        getMainAccount();
                        getPartners();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $(document).on('click', '.delete_new_row', function(e){
                e.preventDefault();
                $(this).closest(".new_added_row").remove();
            });

            $(document).on('submit', '.journal_update_form', function(event){

                event.preventDefault();
                go_for_form_submit();
            });

            function go_for_form_submit(){
                let formElement = $('.journal_update_form').serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',APP_TOKEN);
                $.ajax({
                    url: $('#journal_update_url').val(),
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        if(response.message_warning !== undefined)
                        {
                            toastr.warning(response.message_warning);
                        }else if (response.message !== undefined) {
                            $(".entry_row_div").html("");
                            $(".narration").val("");
                            toastr.success(response.message);
                            window.location.replace(response.url);
                        }else {
                            toastr.error("Something went wrong");
                        }
                    },
                    error:function(response) {
                        if (response.message_error !== undefined) {
                            toastr.error(response.message_error)
                        }else {
                            toastr.error(response.responseJSON.message);
                        }
                    }
                });
            }

            function sumAmount()
            {
                var debit_amounts = $("input[name='debit_amount[]']").map(function(){return $(this).val();}).get();
                var credit_amounts = $("input[name='credit_amount[]']").map(function(){return $(this).val();}).get();
                var debit_amounts_sum = 0;
                var credit_amounts_sum = 0;
                for (var i = 0; i < debit_amounts.length; i++) {
                    debit_amounts_sum = parseFloat(debit_amounts_sum) + parseFloat(debit_amounts[i]);
                }
                for (var i = 0; i < credit_amounts.length; i++) {
                    credit_amounts_sum = parseFloat(credit_amounts_sum) + parseFloat(credit_amounts[i]);
                }
                if (parseFloat(credit_amounts_sum) > parseFloat(debit_amounts_sum)) {
                    var last_div = $('.entry_row_div .new_added_row:last-child');
                    last_div.find(".debit_amount").val(parseFloat(credit_amounts_sum) - parseFloat(debit_amounts_sum));
                }
                if (parseFloat(debit_amounts_sum) > parseFloat(credit_amounts_sum)) {
                    var last_div = $('.entry_row_div .new_added_row:last-child');
                    last_div.find(".credit_amount").val(parseFloat(debit_amounts_sum) - parseFloat(credit_amounts_sum));
                }

                getSumAmount();
            }

            function getSumAmount()
            {
                var debit_amounts = $("input[name='debit_amount[]']").map(function(){return $(this).val();}).get();
                var credit_amounts = $("input[name='credit_amount[]']").map(function(){return $(this).val();}).get();
                var debit_amounts_sum = 0;
                var credit_amounts_sum = 0;
                for (var i = 0; i < debit_amounts.length; i++) {
                    if (debit_amounts[i] != '') {
                        debit_amounts_sum = parseFloat(debit_amounts_sum) + parseFloat(debit_amounts[i]);
                    }
                }
                for (var i = 0; i < credit_amounts.length; i++) {
                    if (credit_amounts[i] != '') {
                        credit_amounts_sum = parseFloat(credit_amounts_sum) + parseFloat(credit_amounts[i]);
                    }
                }
                var currency = $('#currency_symbol').val();
                $('.total_debit_amount').text(currency+' '+parseFloat(debit_amounts_sum.toFixed(2)));
                $('.total_credit_amount').text(currency+' '+parseFloat(credit_amounts_sum.toFixed(2)));
            }
    
            $(document).on('keyup', '.debit_amount, .credit_amount', function(){
                if (inputTimeout) {
                    clearTimeout(inputTimeout);
                }
                inputTimeout = setTimeout(getSumAmount, 500);
            });

            function getMainAccount(){
                $(".account_id").select2({
                    ajax: {
                        url: $('#ledger_list_select_option').val(),
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    type: "transactional",
                                    branch_id: $(".branch_id").val()
                                }
                                return query;
                        },
                        cache: false
                    },
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            }

            function getPartners(){
                $(".sub_account_id").select2({
                    ajax: {
                        url: "{{route('sub-ledger.transactional_list_for_select')}}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                                var query = {
                                    search: params.term,
                                    page: params.page || 1,
                                    branch_id: $(".branch_id").val()
                                }
                                return query;
                        },
                        cache: false
                    },
                    escapeMarkup: function (m) {
                        return m;
                    }
                });
            }
        })(jQuery);
    </script>
@endpush