
<!-- Add Modal Item_Details -->
<div class="modal fade" id="detail_info_modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success-subtle">
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
                                    <td>{{$item->sub_ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Work Order Name</td>
                                    <td>{{$item->order_name}}</td>
                                </tr>
                                <tr>
                                    <td>Work Order No</td>
                                    <td>{{$item->order_no}}</td>
                                </tr>
                                <tr>
                                    <td>Work Order Value</td>
                                    <td>{{currencySymbol($item->order_value)}}</td>
                                </tr>
                                <tr>
                                    <td>Cost Amount</td>
                                    <td>{{currencySymbol($item->work_order_estimation_costs->sum('estimated_amount'))}}</td>
                                </tr>
                                <tr>
                                    <td>Is Active</td>
                                    <td>{{$item->is_active  == 1 ? "Yes" : "No"}}</td>
                                </tr>
                                <tr>
                                    <td>Creation Date</td>
                                    <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                </tr>
                                <tr>
                                    <td>Close Date</td>
                                    <td>{{ date('d/m/Y', strtotime($item->final_date)) }}</td>
                                </tr>
                                <tr>
                                    <td>Remarks</td>
                                    <td>{{$item->remarks}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered mb-0 mt-4">
                            <tr>
                                <th>Estimated Project Cost</th>
                                <th class="text-right">Amount</th>
                            </tr>
                            @foreach ($item->work_order_estimation_costs as $estimation_cost)
                                <tr>
                                    <td>{{ $estimation_cost->ledger->name }}</td>
                                    <td class="text-right">{{ currencySymbol($estimation_cost->estimated_amount) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <table class="table table-bordered mb-0 mt-4">
                            <tr>
                                <th>Site Name</th>
                                <th>Location</th>
                                <th>Site Manager</th>
                                <th class="text-right">Est. Budget</th>
                            </tr>
                            @foreach ($item->work_order_site_details as $site)
                                <tr>
                                    <td>{{ $site->site_name }}</td>
                                    <td>{{ $site->site_location }}</td>
                                    <td>{{ $site->site_pm_name }}</td>
                                    <td class="text-right">{{ currencySymbol($site->est_budget) }}</td>
                                </tr>
                            @endforeach
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
