@extends('client.layouts.app')
@section('title', config('app.name'). ' - Login')
@section('content')
<div class="bg-primary">
    <div class="site-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-12 col-md-7">
                    <div class="card o-hidden border-0 shadow-lg my-4">
                        <div class="card-body p-0">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h3 class="text-primary mb-4"><b>Welcome Back!</b></h3>

                                        </div>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email">

                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password">

                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <input class="form-group-input " type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-group-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary btn-block py-2">
                                                        {{ __('Login') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <label>Or</label>
                                            </div>
                                            <div class="col-12">
                                                <a class="btn btn-primary btn-block py-2" href="{{ route('auth.google') }}">
                                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text-center">
                                            @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-link" href="register.html">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection