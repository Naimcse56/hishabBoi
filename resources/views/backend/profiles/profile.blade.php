@extends('layouts.admin_app')
@section('title')
My Account
@endsection
@section('content')
<div class="container-fluid px-4">
    <h4 class="mt-4">My Account</h4>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('profile_update') }}" class="text-start mb-3">
                        @csrf
                        <div class="row">
                            <x-common.input :required="true" column=6 id="name" name="name" label="Name" placeholder="Name" :value="old('name',auth()->user()->name)"></x-common.input>
                            <x-common.input :required="true" column=6 id="username" name="username" label="Username" placeholder="Username" :value="old('name',auth()->user()->username)"></x-common.input>
                            <x-common.input :required="true" column=6 type="email" id="email" name="email" label="Email" placeholder="Email" :value="old('email',auth()->user()->email)" readonly></x-common.input>
                            <x-common.input :required="true" column=6 type="password" id="password" name="password" label="Password" placeholder="Password" :value="old('password')"></x-common.input>
                            <x-common.input :required="true" column=6 type="password" id="password_confirmation" name="password_confirmation" label="Confirm Password" placeholder="Confirm Password" :value="old('password_confirmation')"></x-common.input>
                            <x-common.button column=12 type="submit" id="update_btn" class="btn-primary btn-120" :value="'Update'"></x-common.button>
                        </div> <!-- end row -->
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
</div>
@endsection