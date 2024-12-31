
<!-- Add Modal Item_Details -->
<div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{$ledger->name}} Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td>Account Type</td>
                                    <td>{{$ledger->TypeName}}</td>
                                </tr>
                                <tr>
                                    <td>Parent Account</td>
                                    <td>{{$ledger->parent->name}}</td>
                                </tr>
                                <tr>
                                    <td>Account Name</td>
                                    <td>{{$ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Account Code</td>
                                    <td>{{$ledger->code}}</td>
                                </tr>
                                @if ($ledger->acc_type == "bank")
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
                                    <tr>
                                        <td>Bank Address</td>
                                        <td>{{$ledger->bank_address}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Ledger Type</td>
                                    <td>{{$ledger->acc_type}}</td>
                                </tr>
                                <tr>
                                    <td>Balance</td>
                                    <td>{{currencySymbol($ledger->BalanceAmount)}}</td>
                                </tr>
                                <tr>
                                    <td>Child Account</td>
                                    <td>
                                        @foreach ($ledger->childrenCategories as $child_account)
                                            ({{$child_account->code}}) {{$child_account->name}} <br>
                                            @foreach ($child_account->childrenCategories as $child)
                                                ({{$child->code}}) {{$child->name}} <br>
                                            @endforeach
                                        @endforeach
                                    </td>
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
