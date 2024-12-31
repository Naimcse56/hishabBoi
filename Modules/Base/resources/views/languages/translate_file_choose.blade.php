
<!-- Add Modal Item_Details -->
<div class="modal fade" id="voucher_info_modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Choose Translation file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-2 pb-2">
                <div class="row mb-0">
                    @foreach ($files as $key => $value)
                        <div class="col-md-12">
                            @if(!(is_array($value)))
                                @php
                                    $file_name = basename($value, '.php')
                                @endphp
                                <a href="{{route('language.get_translate_file',['file_name'=>$file_name,'language_id'=>$language->id])}}" class="btn btn-sm btn-primary">Translate this File : {{ $file_name }}</a>
                            @else
                                @foreach ($value as $k => $v)
                                    @php
                                        $file_name = $key .'::'.basename($v, '.php')
                                    @endphp
                                    <a href="{{route('language.get_translate_file',['file_name'=>$file_name,'language_id'=>$language->id])}}" class="btn btn-sm btn-primary">Translate this File : {{ ucwords($file_name) }}</a>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>