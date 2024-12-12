
@php
    if ($product->selling_price_tax > 0) {
        $per_product_tax = $product->selling_price * $product->selling_price_tax / 100;
        $sale_price = $product->selling_price + $per_product_tax;
    } else {
        $sale_price = $product->selling_price;
    }
@endphp
<div class="row new_added_row">
    <input type="hidden" name="product_id[]" value="{{$product->id}}">
    <x-common.input :required="true" column=4 name="name[]" label="Product Name" placeholder="Product Name" :value="$product->name"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=1 name="qty[]" class="qty" label="QTY" placeholder="QTY" :value="1"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="sale_price_tax[]" class="sale_price_tax" label="Purchase Tax (%)" placeholder="0" :value="$product->selling_price_tax"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="sale_price[]" class="sale_price" label="Purchase Price" placeholder="Purchase Price" :value="$product->selling_price"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="total_sale_price[]" class="total_sale_price" label="Total Price" placeholder="Total Price" :value="$sale_price"></x-common.input>
    <div class="col-md-1 mb-3">
        <label class="form-label" for=""> Action </label>
        <div>
            <a class="btn btn-sm btn-outline-danger delete_leadger delete_new_row"><i class="fa fa-trash"></i></a>
        </div>
    </div>
</div>