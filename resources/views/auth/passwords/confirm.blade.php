@extends('layouts.login_app')

@section('content')

<div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
    <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
        <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                <a href="index.html" class="auth-brand mb-3">
                    <img src="{{asset('assets/images/logo.png')}}" alt="dark logo" height="24" class="logo-dark">
                    <img src="{{asset('assets/images/logo.png')}}" alt="logo light" height="24" class="logo-light">
                </a>

                <h3 class="fw-semibold mb-2">{{ __('Confirm Password') }}</h3>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h4 class="fw-semibold mb-2">{{ __('Please confirm your password before continuing.') }}</h4>
                <form method="POST" action="{{ route('password.confirm') }}" class="text-start mb-3">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary" type="submit">{{ __('Confirm Password') }}</button>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="fw-semibold text-dark ms-1" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
