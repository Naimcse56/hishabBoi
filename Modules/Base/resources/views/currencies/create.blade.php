
<!-- Add Modal Item_Details -->
<div class="modal fade" id="exampleLargeModal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">New Currency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_form">
                    <div class="row">
                        <x-common.input :required="true" column=12 id="name" name="name" label="Currency Name" placeholder="Currency Name" :value="old('name')"></x-common.input>
                        <x-common.input :required="true" column=12 id="code" name="code" label="Currency Code" placeholder="Currency Code" :value="old('code')"></x-common.input>
                        <x-common.input :required="true" column=12 id="symbol" name="symbol" label="Currency Symbol" placeholder="Currency Symbol" :value="old('symbol')"></x-common.input>
                        <x-common.button column=12 type="button" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>