@extends('layouts.login_app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center w-100">
        <div class="login-form">
            <div class="text-center">
                <img src="{{ asset('assets/images/icon.png') }}"  width="65px"/>
                <h4 class="login-title">E-Billing & Accounting</h4>
            </div>
            <form method="POST" action="{{ route('password.email') }}" class="text-start mb-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

