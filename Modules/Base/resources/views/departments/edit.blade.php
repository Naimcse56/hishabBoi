
<!-- Add Modal Item_Details -->
<div class="modal fade" id="editModal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Edit Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('departments.update', encrypt($item->id))}}">
                    @csrf
                    <div class="row">
                        <x-common.input :required="true" column=12 id="name" name="name" label="Department Name" placeholder="Department Name" :value="$item->name"></x-common.input>
                        <x-common.button column=12 type="submit" id="update-btn" class="btn-primary btn-120 update-btn" :value="' Update'" :icon="'fa fa-check'"></x-common.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>