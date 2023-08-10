@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="main-logo">
                            </a>
                        </div>
                        <!-- /Logo -->
                        @include('notification')

                        <h5 class="mb-2">Welcome to {{ config('variables.templateName') }}! 👋</h5>
                        <p class="mb-4">Please sign-in to your account.</p>

                        <form id="loginForm" class="mb-3" action="{{ route('loginPost') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" autofocus value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" value="{{ old('password') }}" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">

                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember-me" name="remember_me">
                                        <label class="form-check-label" for="remember-me">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="{{ url('auth/forgot-password') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>


                            </div>
                            <div class="mb-3">
                                <button class="btn btn-warning w-100 text-dark" type="button" id="signIn">Sign
                                    in</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register-basic')}}">
              <span>Create an account</span>
            </a>
          </p> --}}
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#signIn').on('click', function() {
                let btn = $(this)
                btn.attr("disabled", "disabled")
                btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
                let form = $('#loginForm')
                setTimeout(() => {
                    form.submit();
                }, 900);
            });


            $('#loginForm').on('keypress', function(event) {
                if (event.which === 13 || event.keyCode === 13) {
                    $('#signIn').trigger('click');
                }
            });

        });
    </script>
@endpush
