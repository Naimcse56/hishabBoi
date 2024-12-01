
<!-- Add Modal Item_Details -->
<div class="modal fade" id="detail_info_modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Party Account Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="30%">Head Account</td>
                                    <td>
                                        @if ($ledger->supplier > 0)
                                            {{$ledger->supplier_info->name}}
                                        @elseif ($ledger->customer > 0)  
                                            {{$ledger->customer_info->name}}
                                        @elseif ($ledger->member > 0)
                                            {{$ledger->member_info->name}}
                                        @elseif ($ledger->land_owner > 0)
                                            {{$ledger->land_owner_info->name}}
                                        @else
                                            {{$ledger->ledger->name}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Party Name</td>
                                    <td>{{$ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Party Email</td>
                                    <td><a href="{{$ledger->email}}">{{$ledger->email}}</a></td>
                                </tr>
                                <tr>
                                    <td>Phone / Code</td>
                                    <td>{{$ledger->code}}</td>
                                </tr>
                                <tr>
                                    <td>BIN</td>
                                    <td>{{$ledger->bin}}</td>
                                </tr>
                                <tr>
                                    <td>TIN</td>
                                    <td>{{$ledger->tin}}</td>
                                </tr>
                                <tr>
                                    <td>Is Active</td>
                                    <td>{{$ledger->is_active  == 1 ? "Yes" : "No"}}</td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{currencySymbol($ledger->BalanceAmount)}}</td>
                                </tr>
                                <tr>
                                    <td>Bank Name</td>
                                    <td>{{$ledger->bank_name}}</td>
                                </tr>
                                <tr>
                                    <td>Bank Account Name</td>
                                    <td>{{$ledger->bank_ac_name}}</td>
                                </tr>
                                <tr>
                                    <td>Routing No</td>
                                    <td>{{$ledger->routing_no}}</td>
                                </tr>
                                <tr>
                                    <td>Swift Code</td>
                                    <td>{{$ledger->swift_code}}</td>
                                </tr>
                                <tr>
                                    <td>Branch Code</td>
                                    <td>{{$ledger->branch_code}}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
