@extends('layouts.admin_app')
@section('title')
Staff Details
@endsection
@section('content')
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between">
            <div><h4 class="mt-4">Staff Details</h4></div>
            <div><a href="{{route('staffs.index')}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-list"></i> List</a></div>
            <div><a href="{{route('staffs.show',encrypt($staff->id))}}" class="btn btn-sm btn-primary mt-4"><i class="fa fa-edit"></i> Edit</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-3">
                                        <h4>{{ @$staff->user->name }}</h4>
                                        <h6>{{ @$staff->designation->name }}</h6>
                                        <h6>
                                            {{ @$staff->department->name }}
                                            @if ($staff->user->is_active == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <h6>{{ app('general_setting')['company_name'] }}</h6>
                                        <h6>{{ app('general_setting')['company_address'] }}</h6>
                                        <h6>{{ app('general_setting')['company_phone'] }}, {{ app('general_setting')['company_email'] }}</h6>
                                    </div>
                                </div>
                                <hr class="mt-3"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-envelope"></i> Email</h6>
                                        <span class="text-primary">{{ $staff->user->email }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-phone"></i> Phone</h6>
                                        <span class="text-primary">{{ $staff->phone }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-address-card"></i> Staff ID</h6>
                                        <span class="text-primary">{{ $staff->staff_id }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-calendar"></i> Date of Birth</h6>
                                        <span class="text-primary">{{ showDateFormat($staff->date_of_birth) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-calendar"></i> Joining Date</h6>
                                        <span class="text-primary">{{ showDateFormat($staff->joining_date) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-link"></i> Resume URL</h6>
                                        <a href="{{ asset($staff->cv) }}" download="{{str_replace(' ','-',$staff->staff_id.'-Resume')}}" class="text-primary">Download Resume</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-link"></i> NID URL</h6>
                                        <a href="{{ asset($staff->nid) }}" download="{{str_replace(' ','-',$staff->staff_id.'-NID')}}" class="text-primary">Download NID</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-bar-chart"></i> Employee Ledger</h6>
                                        <span class="text-primary">{{ $staff->morph->ledger->name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Bank Name</h6>
                                        <span class="text-primary">{{ $staff->morph->bank_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Bank Account Name</h6>
                                        <span class="text-primary">{{ $staff->morph->bank_ac_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Routing No</h6>
                                        <span class="text-primary">{{ $staff->morph->routing_no }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Bank Account No</h6>
                                        <span class="text-primary">{{ $staff->morph->ac_no }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Branch Code</h6>
                                        <span class="text-primary">{{ $staff->morph->branch_code }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-building"></i> Swift Code</h6>
                                        <span class="text-primary">{{ $staff->morph->swift_code }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0"><i class="fa fa-user"></i> Employement Status</h6>
                                        <span class="text-primary">{{ $staff->employement_status }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection