@extends('layouts.login_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-success-light"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">
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
                            <input class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>
                            <label class="form-check-label" for="remember">Remember Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                            @if (Route::has('password.request'))
                                <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3 bg-success-light">
                    <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
