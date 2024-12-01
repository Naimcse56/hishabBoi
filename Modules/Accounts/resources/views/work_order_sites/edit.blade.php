@extends('layouts.admin_app')
@section('title')
Work Order Site
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
                                <div class="col-md-6 mb-2">
                                    <label class="form-label" for="Head Account">Work Order Name <span class="text-danger">*</span></label>
                                    <select class="form-select work_order_id" name="work_order_id" required>
                                        <option value="{{$item->work_order_id}}" selected>({{$item->work_order->order_no}}) {{$item->work_order->order_name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="site_name" class="form-label">Site Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Site Name" value="{{$item->site_name}}" required>
                                    <span class="text-danger" id="site_name_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mt-2" for="site_location">Site Location</label>
                                    <input id="site_location" name="site_location" class="form-control" placeholder="Site Location" type="text" value="{{$item->site_location}}">
                                    <span class="text-danger" id="site_location_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label mt-2" for="est_budget">Est. Budget <span class="text-danger">*</span></label>
                                    <input id="est_budget" name="est_budget" class="form-control" placeholder="Est. Budget" type="number" step="0.01" min="0" value="{{$item->est_budget}}" required>
                                    <span class="text-danger" id="est_budget_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="site_pm_name" class="form-label">Site Manager</label>
                                    <input type="text" class="form-control" id="site_pm_name" name="site_pm_name" placeholder="Site Manager" value="{{$item->site_pm_name}}">
                                    <span class="text-danger" id="site_pm_name_error"></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Remarks</label>
                                    <textarea class="form-control" id="note" name="note" placeholder="Remarks ..." rows="3">{{$item->note}}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary"><i class="bx bx-check-double"></i>Save</button>
                                </div>
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