
<!-- Add Modal Item_Details -->
<div class="modal fade" id="exampleLargeModal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">New Language</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="chart_account_form">
                    <div class="row">
                        <x-common.input :required="true" column=12 id="name" name="name" label="Name" placeholder="Name" :value="old('name')"></x-common.input>
                        <x-common.input :required="true" column=12 id="code" name="code" label="Code" placeholder="Code" :value="old('code')"></x-common.input>
                        <x-common.radio :required="true" column=6 name="rtl" class="rtl" label="RTL" placeholder="RTL" :value="0" :options="[
                            ['id' => 1, 'name' => 'Yes'],
                            ['id' => 0, 'name' => 'No']
                        ]"></x-common.radio>
                        <x-common.radio :required="true" column=6 name="status" class="status" label="Status" placeholder="Status" :value="1" :options="[
                            ['id' => 1, 'name' => 'Active'],
                            ['id' => 0, 'name' => 'Inactive']
                        ]"></x-common.radio>
                        <x-common.button column=12 type="button" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>