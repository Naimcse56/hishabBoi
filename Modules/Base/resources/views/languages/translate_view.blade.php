@extends('layouts.admin_app')
@section('title')
Language Translation
@endsection
@section('content')

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
        <div><h4 class="mt-4">{{ $language->name }} Translation</h4></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ $language->id }}">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <input type="hidden" name="id" id="id" value="{{ $language->id }}">
                            <label for="file_name" class="form-label">Choose File <span class='text-danger'>* </span></label>
                            <select class="form-control file_name" id="file_name" name="file_name" aria-invalid="false" required>
                                @foreach ($files as $key => $value)
                                    @if(!(is_array($value)))
                                        @php
                                            $file_name = basename($value, '.php')
                                        @endphp

                                        <option value="{{ $file_name }}" @if ($key == 0) selected @endif>{{ $file_name }}</option>
                                    @else
                                        @foreach ($value as $k => $v)
                                            @php
                                                $file_name = $key .'::'.basename($v, '.php')
                                            @endphp
                                            <option value="{{ $file_name }}">{{ ucwords($file_name) }}</option>
                                        @endforeach

                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12" id="translate_form">
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script type="text/javascript">
        $('#file_name').select2();
        $(document).ready(function () {
            get_translate_file();
        });
        $(document).on('change','#file_name', function(){
            get_translate_file()
        });
        function get_translate_file() {
            var file_name = $('#file_name').val();
            var id = $('#id').val();
            $.post('{{ route('language.get_translate_file') }}', {
                _token: '{{ csrf_token() }}',
                file_name: file_name,
                id: id
            }, function (data) {
                $('#translate_form').html(data);
            });
        }
    </script>
@endpush
