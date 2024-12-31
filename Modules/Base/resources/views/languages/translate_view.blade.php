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
                    <form action="{{ route('language.key_value_store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $language->id }}">
                    <input type="hidden" name="translatable_file_name" value="{{ $translatable_file_name }}">
                    <button id="save-btn" type="submit" class="btn btn-sm btn-primary btn-120 save-btn"><i class="fa fa-check"></i> Save</button>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">{{ __('base::base.key') }}</th>
                            <th scope="col">{{ __('base::base.value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($languages as $key => $value)
                                <tr>
                                    <th scope="row">{{ $key }}</th>
                                    <td><input type="text" class="form-control" name="key[{{ $key }}]" @isset($value) value="{{ $value }}" @endisset></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

