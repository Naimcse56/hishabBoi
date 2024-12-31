
<!-- Add Modal Item_Details -->
<div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">{{$product->type}} Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td colspan="2"><img src="{{asset('storage/'.$product->image)}}" alt="{{$product->name}}" class="w-25"></td>
                                </tr>
                                <tr>
                                    <td>Product Name</td>
                                    <td>{{$product->name}}</td>
                                </tr>
                                <tr>
                                    <td>Product Unit</td>
                                    <td>{{$product->product_unit->name}}</td>
                                </tr>
                                <tr>
                                    <td>For Selling</td>
                                    <td>{{$product->for_selling}}</td>
                                </tr>
                                <tr>
                                    <td>Selling Account</td>
                                    <td>{{$product->selling_ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Selling Price</td>
                                    <td>{{currencySymbol($product->selling_price)}}</td>
                                </tr>
                                <tr>
                                    <td>For Purchase</td>
                                    <td>{{$product->for_purchase}}</td>
                                </tr>
                                <tr>
                                    <td>Purchase Account</td>
                                    <td>{{$product->purchase_ledger->name}}</td>
                                </tr>
                                <tr>
                                    <td>Purchase Price</td>
                                    <td>{{currencySymbol($product->purchase_price)}}</td>
                                </tr>
                                <tr>
                                    <td>Details</td>
                                    <td>{{$product->details}}</td>
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
