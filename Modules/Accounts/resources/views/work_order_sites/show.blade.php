
<!-- Add Modal Item_Details -->
<div class="modal fade" id="detail_info_modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Work Order Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td width="20%">Client</td>
                                    <td>{{$item->work_order->sub_ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Work Order Name</td>
                                    <td>{{$item->work_order->order_name}}</td>
                                </tr>
                                <tr>
                                    <td>Work Order No</td>
                                    <td>{{$item->work_order->order_no}}</td>
                                </tr>
                                <tr>
                                    <td>Site Name</td>
                                    <td>{{$item->site_name}}</td>
                                </tr>
                                <tr>
                                    <td>Site Location</td>
                                    <td>{{$item->site_location}}</td>
                                </tr>
                                <tr>
                                    <td>Site Manager</td>
                                    <td>{{$item->site_pm_name}}</td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td>{{$item->note}}</td>
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
