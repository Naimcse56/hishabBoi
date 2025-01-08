@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card install-card position-relative position-relative">
                <!-- Content -->
                <div class="card-body h-100 w-100 z-3">
                    <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">Database setup</h1>
                        <p class="fs-12 fw-500" style="color:  #666; line-height: 18px;">Fill this form with valid database credentials</p>
                    </div>

                    @if (isset($error))
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                            <strong>Invalid Database Credentials!! </strong>Please check your database credentials carefully
                            </div>
                        </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('install.db') }}">
                        @csrf
                        <div class="form-group">
                            <label for="db_host" class="fs-12 fw-500" style="color: #666;">Database Host</label>
                            <input type="text" class="form-control rounded-2 border" style="height: 36px !important;" id="db_host" name = "DB_HOST" required autocomplete="off">
                            <input type="hidden" name = "types[]" value="DB_HOST">
                        </div>
                        <div class="form-group">
                            <label for="db_name" class="fs-12 fw-500" style="color: #666;">Database Name</label>
                            <input type="text" class="form-control rounded-2 border" style="height: 36px !important;" id="db_name" name = "DB_DATABASE" required autocomplete="off">
                            <input type="hidden" name = "types[]" value="DB_DATABASE">
                        </div>
                        <div class="form-group">
                            <label for="db_user" class="fs-12 fw-500" style="color: #666;">Database Username</label>
                            <input type="text" class="form-control rounded-2 border" style="height: 36px !important;" id="db_user" name = "DB_USERNAME" required autocomplete="off">
                            <input type="hidden" name = "types[]" value="DB_USERNAME">
                        </div>
                        <div class="form-group">
                            <label for="db_pass" class="fs-12 fw-500" style="color: #666;">Database Password</label>
                            <input type="password" class="form-control rounded-2 border" style="height: 36px !important;" id="db_pass" name = "DB_PASSWORD" autocomplete="off">
                            <input type="hidden" name = "types[]" value="DB_PASSWORD">
                        </div>
                        <div class="mb-4 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                            @php
                                $route = ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') ? route('step1') :  route('step2') 
                            @endphp
                            <button type="submit" class="btn btn-primary text-uppercase mt-3">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
