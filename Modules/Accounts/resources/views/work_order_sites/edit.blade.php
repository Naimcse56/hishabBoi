@extends('layouts.admin_app')
@section('title')
Edit Work Order Site
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Edit Work Order Site</h4></div>
            <div><a href="{{route('work-order-sites.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-plus"></i> List</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('work-order-sites.update', encrypt($item->id))}}">
                            @csrf
                            <div class="row">
                                <x-common.server-side-select :required="true" column=4 name="work_order_id" id="work_order_id" class="work_order_id" disableOptionText="Select Work Order" label="Work Order Name" :options="[
                                    ['id' => $item->work_order_id, 'name' => $item->work_order->order_name]
                                ]" :value="$item->work_order_id"></x-common.server-side-select>
                                <x-common.input :required="true" column=4 id="site_name" name="site_name" label="Site Name" placeholder="Site Name" :value="old('site_name',$item->site_name)"></x-common.input>
                                <x-common.input :required="false" column=4 id="site_location" name="site_location" label="Site Location" placeholder="Site Location" :value="old('site_location',$item->site_location)"></x-common.input>
                                <x-common.input :required="false" column=4 id="est_budget" name="est_budget" label="Est. Budget" placeholder="Est. Budget" type="number" step="0.01" min="0" :value="old('est_budget',$item->est_budget)"></x-common.input>
                                <x-common.input :required="false" column=4 id="site_pm_name" name="site_pm_name" label="Site Manager" placeholder="Site Manager" :value="old('site_pm_name',$item->site_pm_name)"></x-common.input>
                                <x-common.text-area :required="false" column=12 name="note" label="Remarks" placeholder="Remarks..." :value="$item->note"></x-common.text-area>
                            </div>
                            <div class="row">
                                <x-common.button column=12 type="submit" id="update-btn" class="btn-primary btn-120 update-btn" :value="' Save'" :icon="'fa fa-check'"></x-common.button>
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
            $(".work_order_id").select2({
                ajax: {
                    url: '{{route('work-order.list_for_select')}}',
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