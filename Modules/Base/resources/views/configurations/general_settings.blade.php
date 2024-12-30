@extends('layouts.admin_app')
@section('title')
General Setting
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">General Settings</h4></div>
               </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form class="create_form" action="{{route('base_settings_update.configurations')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <x-common.server-side-select :required="true" column=6 name="system_currency_id" id="system_currency_id" class="system_currency_id" disableOptionText="Select One" label="System Currency" :options="[
                                    ['id' => app('general_setting')['system_currency_id'].'-'.app('general_setting')['system_currency_symbol'], 'name' => app('general_setting')['system_currency_symbol']]
                                ]" :value="app('general_setting')['system_currency_id'].'-'.app('general_setting')['system_currency_symbol']"></x-common.server-side-select>
                                <x-common.select :required="true" column=6 name="date_format" class="date_format" label="Date Format" placeholder="Date Format" :value="'d/m/Y'" :options="[
                                    ['id' => 'jS M, Y', 'name' => '17th May, 2019'],
                                    ['id' => 'Y-m-d', 'name' => '2019-05-17'],
                                    ['id' => 'Y-d-m', 'name' => '2019-05-19'],
                                    ['id' => 'Y/m/d', 'name' => '2019/05/17'],
                                    ['id' => 'd/m/Y', 'name' => '17/05/2019']
                                ]"></x-common.select>                                
                                <x-common.server-side-select :required="true" column=6 name="system_language" id="system_language" class="system_language" disableOptionText="Select One" label="System Language" :options="[
                                    ['id' => app('general_setting')['system_language'], 'name' => app('general_setting')['system_language']]
                                ]" :value="app('general_setting')['system_language']"></x-common.server-side-select>
                            </div>
                         
                            <div class="row">
                                <x-common.button column=12 type="submit" id="save-btn" class="btn-primary btn-120 save-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
                            </div>
                        </form>
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
            
            $(".system_currency_id").select2({
                ajax: {
                    url: '{{route('currencies.list_for_select')}}',
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
            
            $(".system_language").select2({
                ajax: {
                    url: '{{route('language.list_for_select')}}',
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