@extends('layouts.admin_app')
@section('title')
Staff Permissions
@endsection
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between">
       <div>
          <h4 class="mt-4">Staff Permissions</h4>
       </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="create_form" action="#" method="GET" >
                        @csrf
                        <div class="row">
                            <x-common.server-side-select :required="true" column=12 name="user_id" id="user_id" class="user_id" disableOptionText="Select One" label="Staff Permission"></x-common.server-side-select>
                            <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Go Next'" :icon="'fa fa-check'"></x-common.button>
                        </div>
                    </form>
                    @if($user_id)
                    <div>
                        <h5 class="mt-4">Permissions List for {{ $user->name }} ({{ $user->staff->staff_id }})</h5>
                    </div>
                    <form class="create_form permission" action="{{ route('store.permisssions') }}" method="POST"  >
                        @csrf
                        <input type="hidden" value="{{ $user_id }}"  name="user_id"/>
                        <div class="row">
                            @foreach ($permissions as $permission) 
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="{{ $permission->name }}"
                                    @foreach ($assigned_permissions as $assigned_permission) 
                                    @if($assigned_permission == $permission->name) checked @endif
                                    @endforeach
                                    >
                                    <label class="form-check-label" for="{{ $permission->name }}">
                                    {{ $permission->label }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection
@push('scripts')
    <script>
        (function($) {
            "use strict";
            APP_TOKEN;
            $(".user_id").select2({
                ajax: {
                    url: '{{route('staffs.list_for_select')}}',
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                            var query = {
                                search: params.term,
                                page: params.page || 1,
                            }
                            return query;
                    },
                    cache: false
                },
                escapeMarkup: function (m) {
                    return m;
                }
            });
        })(jQuery);
    </script>
@endpush