<form class="" action="{{ route('language.key_value_store') }}" method="post">
    <div class="row" id="translate_modal">
        @csrf
        <div class="col-md-12">
            <input type="hidden" name="id" value="{{ $language->id }}">
            <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
            <div class="col-lg-12 mb-2">
                <button id="save-btn" type="button" class="btn btn-sm btn-primary btn-120 save-btn"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                       <tr>
                          <th scope="col">{{ __('base::base.sl') }}</th>
                          <th scope="col">{{ __('base::base.key') }}</th>
                          <th scope="col">{{ __('base::base.value') }}</th>
                       </tr>
                    </thead>
                    <tbody>
                       @php
                       $i = 1
                       @endphp
                       @foreach ($languages as $key => $value)
                       <tr>
                          <td>{{ $i }}</td>
                          <td>{{ $key }}</td>
                          <td>
                             @if( is_array($value) )
                             <table class="table">
                                <tbody>
                                   @foreach($value as $sub_key => $sub_value)
                                   <tr>
                                      <td width="10%">{{ $sub_key }}</td>
                                      <td>
                                         @if( is_array($sub_value) )
                                         <table class="table">
                                            <tbody>
                                               @foreach($sub_value as $sub_sub_key => $sub_sub_value)
                                               <tr>
                                                  <td>{{ $sub_sub_key }}</td>
                                                  <td>
                                                     <div class="col-lg-12">
                                                        <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}][{{ $sub_key }}][{{ $sub_sub_key }}]" @isset($sub_sub_value) value="{{ $sub_sub_value }}" @endisset>
                                                     </div>
                                                  </td>
                                               </tr>
                                               @endforeach
                                            </tbody>
                                         </table>
                                         @else
                                         <div class="col-lg-12">
                                            <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}][{{ $sub_key }}]" @isset($sub_value) value="{{ $sub_value }}" @endisset>
                                         </div>
                                         @endif
                                      </td>
                                   </tr>
                                   @endforeach
                                </tbody>
                             </table>
                             @else
                             <div class="col-lg-12">
                                <input type="text" class="form-control" style="width:100%" name="key[{{ $key }}]" @isset($value) value="{{ $value }}" @endisset>
                             </div>
                             @endif
                          </td>
                       </tr>
                       @php
                       $i++
                       @endphp
                       @endforeach
                    </tbody>
                 </table>
            </div>
        </div>
    </div>
</form>
