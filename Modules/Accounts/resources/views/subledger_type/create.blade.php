
<!-- Add Modal Item_Details -->
<div class="modal fade" id="exampleLargeModal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">New Party Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="chart_account_form">
                    <div class="row">
                        <x-common.input :required="true" column=12 id="name" name="name" label="Name" placeholder="Name" :value="old('name')"></x-common.input>
                        <x-common.radio :required="true" column=12 name="is_for" class="is_for" label="Type For" :value="'1'" :options="[
                            ['id' => '1', 'name' => 'Supplier / Vendor'],
                            ['id' => '2', 'name' => 'Client'],
                            ['id' => '0', 'name' => 'Staff']
                        ]"></x-common.radio>
                        <x-common.button column=12 type="button" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>