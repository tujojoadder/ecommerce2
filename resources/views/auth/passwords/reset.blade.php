@extends('layouts.user.auth')
<style>
    .border-radius-20 {
        border-radius: 20px;
    }
</style>
@section('content')
    <div class="col-md-10 px-0 shadow d-flex align-items-center border-radius-20 border border-white overflow-hidden bg-white">
        <div class="wd-md-70p login d-none d-md-flex page-signin-style p-0 text-white border-radius-20 overflow-hidden">
            <div class="my-auto authentication-pages">
                <img src="{{ config('company.banner') ?? asset('dashboard/img/bhisab_banner.png') }}" class="w-100 h-100" alt="logo">
            </div>
        </div>
        <div class="p-5 wd-md-50p">
            <div class="main-signin-header">
                <h2>{{ __('Reset Password!') }}</h2>
                <h4>{{ __('Please Enter Your Email') }}</h4>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Enter valid email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Choose new password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Re type password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-3">{{ __('Reset Password') }}</button>
                </form>
            </div>
            <div class="main-signup-footer mg-t-10">
                <p>{{ __('Forget it') }}, <a href="{{ route('login') }}"> {{ __('Send me back') }}</a> {{ __('to the sign in screen') }}.</p>
            </div>
        </div>
    </div>
@endsection
