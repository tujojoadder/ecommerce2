@extends('layouts.user.auth', ['pageTitle' => 'Signin'])
<style>
    .border-radius-20 {
        border-radius: 20px;
    }
</style>
@section('content')
    @php
        $erpdemo = request()->getHost();
        if ($erpdemo == 'erpdemo.bhisab.com') {
            $login = 'admin';
            $password = 'admin1234';
        } else {
            $login = '';
            $password = '';
        }
    @endphp
    <div class="row px-0 mx-auto d-none d-lg-block">
        <div class="col-md-12 d-flex justify-content-center px-0">
            <div class="card p-1 p-lg-4">
                <h3 class="text-center text-primary d-none d-lg-block">Welcome To {{ config('company.name') }}.</h3>
                @if ($erpdemo == 'erpdemo.bhisab.com')
                    <p class="text-center mb-0 d-none d-lg-block">{{ __('messages.intro_text') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-10 px-0 shadow d-flex border-radius-20 border border-white overflow-hidden bg-white">
        <div class="wd-md-70p login d-none d-md-flex p-0 text-white border-radius-20 overflow-hidden ps-2">
            <div class="my-auto authentication-pages">
                {{-- <img src="{{ asset('dashboard/img/bhisab_banner.png') }}" class="w-100 h-100" alt="logo"> --}}
                <img src="{{ config('company.banner') ?? asset('dashboard/img/bhisab_banner.png') }}" class="vw-100 my-3" style="border-radius: 1rem;" alt="logo">
            </div>
        </div>
        <div class="p-lg-5 p-3 wd-md-40p d-flex align-items-center">
            <div>
                <div class="main-signin-header border p-3 rounded-3">
                    <h3 class="text-center text-primary d-lg-none">Welcome To {{ config('company.name') }}.</h3>
                    @if ($erpdemo == 'erpdemo.bhisab.com')
                        <p class="text-center d-lg-none">{{ __('messages.intro_text') }}</p>
                    @else
                    @endif
                    <h2 class="text-center">{{ __('messages.login') }}</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row login-input">
                            <div class="col-12">
                                <div class="form-group">
                                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login', $login) }}" required autocomplete="login" autofocus>
                                    <label class="animated-label active-label text-white" for="login"><i class="fas fa-user"></i> {{ __('messages.username') }}</label>
                                    @error('login')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $password }}" required autocomplete="current-password">
                                    <label class="animated-label active-label text-white" for="password"><i class="fas fa-lock"></i> {{ __('messages.password') }}</label>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    @if (count($errors))
                                        @foreach ($errors->all() as $error)
                                            <br>
                                            <strong class="text-danger ms-3">{{ $error }}</strong>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="d-flex justify-content-between align-items-center my-3">
                                    <div class="form-check my-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('messages.remember_me') }}
                                        </label>
                                    </div>
                                    @if (!$erpdemo == 'erpdemo.bhisab.com')
                                        <div class="main-signin-footer">
                                            <p class="text-center">
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}">
                                                        {{ __('Forgot Password?') }}
                                                    </a>
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($erpdemo == '-erpdemo.bhisab.com')
                            <div class="d-flex justify-content-center">
                                <div class="">
                                    <canvas id="captchaCanvas" class="d-flex justify-content-center border mb-2 rounded-5" height="50" style="opacity: 0.5; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('dashboard/img/pattern.png') }}')"></canvas>
                                    <div class="input-group">
                                        <input type="" class="form-control ignore-custom" id="captchaInput" placeholder="Enter the text from the image" required>
                                        <button class="w-25 btn mt-0 btn-secondary" type="button" id="resetCaptcha">Reset</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button id="checkCaptcha" class="btn btn-lg shadow btn-success btn-block mt-3 rounded-5">{{ __('messages.login') }}</button>
                    </form>
                    @if ($erpdemo == 'erpdemo.bhisab.com')
                        <div class="d-flex justify-content-between">
                            <div class="a btn mt-2 btn-lg shadow btn-primary" style="width: 45%" id="copyUser">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Admin Login</h6>
                            </div>
                            <div class="a btn mt-2 btn-lg shadow btn-info" style="width: 45%" id="copyStaff">
                                <h6 class="mb-0"><i class="fas fa-user"></i> Staff Login</h6>
                            </div>
                        </div>
                        <ul class="list-group list-group-horizontal px-0 mt-4 justify-content-center">
                            <li class="list-group-item">Username: {{ $login }}</li>
                            <br>
                            <li class="list-group-item">Password: {{ $password }}</li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('layouts.help-and-support')
@endsection
@push('scripts')
    <script>
        $("#copyUser").on('click', function() {
            $("#login").val('admin');
            $("#password").val('admin1234');
            $(".animated-label").addClass('active-label');
            $(".animated-label").addClass('text-white');
        });
        $("#copyStaff").on('click', function() {
            $("#login").val('admin-staff');
            $("#password").val('admin1234');
            $(".animated-label").addClass('active-label');
            $(".animated-label").addClass('text-white');
        });
    </script>

    <!-- At the end of your script -->
    @if ($erpdemo == '-erpdemo.bhisab.com')
        <script>
            $(document).ready(function() {
                const canvas = document.getElementById('captchaCanvas');
                const ctx = canvas.getContext('2d');
                let correctCaptcha;

                function generateRandomString(length) {
                    return Array.from({
                        length
                    }, () => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789' [
                        Math.floor(Math.random() * 62)
                    ]).join('');
                }

                function drawCaptchaText() {
                    const captchaText = generateRandomString(6);
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.font = '30px Arial';
                    const textWidth = ctx.measureText(captchaText).width;
                    const x = (canvas.width - textWidth) / 2;
                    const y = 35;
                    ctx.fillText(captchaText, x, y);
                    return captchaText;
                }

                function resetCaptcha() {
                    correctCaptcha = drawCaptchaText();
                    $('#captchaInput').val('');
                }

                resetCaptcha();

                $('#resetCaptcha').click(resetCaptcha);

                $('#checkCaptcha').click(function() {
                    const userInput = $('#captchaInput').val();
                    if (userInput === correctCaptcha) {
                        $('form').submit();
                    } else {
                        alert('Captcha is incorrect. Please try again.');
                        resetCaptcha();
                    }
                });

                $('form').submit(function(event) {
                    const userInput = $('#captchaInput').val();
                    if (userInput !== correctCaptcha) {
                        alert('Please complete the captcha.');
                        event.preventDefault();
                    }
                    // Additional form submission logic if needed
                });
            });
        </script>
    @endif
@endpush
