
<!-- Add Modal Item_Details -->
<div class="modal fade" id="detail_info_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary-subtle">
                <h5 class="modal-title">Business Unit Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td>Party Name</td>
                                    <td>{{$ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>{{$ledger->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Is Active</td>
                                    <td>{{$ledger->is_active  == 1 ? "Yes" : "No"}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{$ledger->address}}</td>
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
