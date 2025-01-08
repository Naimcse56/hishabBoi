@extends('layouts.install')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-center mt-5">
            <div class="card  position-relative">
                <!-- Content -->
                <div class="card-body -body h-100 w-100 z-3 position-relative">
                    <!-- Top content -->
                    <div class="mar-ver pad-btm text-center">
                        <h1 class="fs-21 fw-700 text-uppercase mt-2" style="color: #3d3d3d;">E-BILLING SETTINGS</h1>
                        <p class="fs-12 fw-500" style="color:  #666; line-height: 18px;">Fill this form with basic information & admin login credentials</p>
                    </div>

                    <form method="POST" action="{{ route('system_settings') }}">
                        @csrf
                        <div class="form-group">
                            <label for="admin_name" class="fs-12 fw-500" style="color: #666;">Admin Name</label>
                            <input type="text" class="form-control rounded-2 border" style="height: 36px !important;" id="admin_name" name="admin_name" required>
                        </div>

                        <div class="form-group">
                            <label for="admin_email" class="fs-12 fw-500" style="color: #666;">Admin Email</label>
                            <input type="email" class="form-control rounded-2 border" style="height: 36px !important;" id="admin_email" name="admin_email" required>
                        </div>

                        <div class="form-group">
                            <label for="admin_password" class="fs-12 fw-500" style="color: #666;">Admin Password (At least 6 characters)</label>
                            <input type="password" class="form-control rounded-2 border" style="height: 36px !important;" id="admin_password" name="admin_password" required>
                        </div>

                        <div class="form-group">
                            <label for="admin_name" class="fs-12 fw-500" style="color: #666;">System Currency</label>
                            <select class="form-control rounded-2 border aiz-selectpicker" style="height: 36px !important;" data-live-search="true" name="system_default_currency" required>
                                @foreach (\Modules\Base\App\Models\Currency::all() as $key => $currency)
                                    <option value="{{ $currency->id }} - {{ $currency->symbol }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 pb-4 absolute-bottom-left right-0 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary text-uppercase">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
