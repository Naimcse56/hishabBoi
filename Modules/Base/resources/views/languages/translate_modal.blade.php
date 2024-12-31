<form action="{{ route('language.key_value_store') }}" method="post">
   @csrf
    <div class="row" id="translate_modal">
        <div class="col-md-12">
            <input type="hidden" name="id" value="{{ $language->id }}">
            <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
        </div>
        <div class="col-lg-12 mb-2">
            <button id="save-btn" type="submit" class="btn btn-sm btn-primary btn-120 save-btn"><i class="fa fa-check"></i> Save</button>
        </div>
        <div class="col-md-12">
            {{-- <div class="table-responsive"> --}}
                <table class="table table-striped table-bordered" style="width:100%">
                  <thead>
                     <tr>
                        <th class="col-1">{{ __('base::base.sl') }}</th>
                        <th class="col-2">{{ __('base::base.key') }}</th>
                        <th class="col-9">{{ __('base::base.value') }}</th>
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
                           <input type="text" class="form-control" name="key[{{ $key }}]" @isset($value) value="{{ $value }}" @endisset>
                        </td>
                     </tr>
                     @php
                        $i++
                     @endphp
                     @endforeach
                  </tbody>
               </table>
            {{-- </div> --}}
        </div>
    </div>
</form>
