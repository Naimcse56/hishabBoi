@extends('layouts.login_app')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row justify-content-center w-100">
        <div class="login-form">
            <div class="text-center">
                <img src="{{ asset('assets/images/icon.png') }}"  width="65px"/>
                <h4 class="login-title">Hishab Boi</h4>
            </div>
            <form method="POST" action="{{ route('login') }}" class="text-start mb-3">
                @csrf
                <div class="form-floating mb-3">
                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" required/>
                    <label for="email">Email address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Password" required/>
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                    <label class="form-check-label" for="remember">Remember Password</label>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                    <button class="btn btn-primary" type="submit">&nbsp;&nbsp; Login &nbsp;&nbsp;</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
