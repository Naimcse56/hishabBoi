
<div class="row new_added_row">
    <input type="hidden" name="product_id[]" value="{{$product->id}}">
    <x-common.input :required="true" column=2 name="name[]" label="Product Name" placeholder="Product Name" :value="$product->name"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=1 name="qty[]" label="QTY" placeholder="QTY" :value="1"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="purchase_price[]" label="Purchase Price" placeholder="Purchase Price" :value="$product->purchase_price"></x-common.input>
    <x-common.input :required="true" type="number" step="0.01" min="0" column=2 name="total_purchase_price[]" label="Total Price" placeholder="Total Price" :value="$product->purchase_price"></x-common.input>
</div>