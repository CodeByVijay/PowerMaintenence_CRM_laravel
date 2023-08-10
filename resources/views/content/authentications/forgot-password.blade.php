@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="main-logo">
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Forgot Password? 🔒</h4>
                        <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                        <form id="forgotPasswordForm" class="mb-3" action="{{route('forgotPassPost')}}" method="post">
                          @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" value="{{ old('email') }}" autofocus>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button class="btn btn-warning w-100" id="formSubmitBtn">Send Reset Link</button>
                        </form>
                        <div class="text-center">
                            <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#formSubmitBtn').on('click', function() {
              let btn = $(this)
              btn.attr("disabled","disabled")
              btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
              let form = $('#forgotPasswordForm')
              setTimeout(() => {
                form.submit();
              }, 900);
            })

            $('#forgotPasswordForm').on('keypress', function(event) {
                if (event.which === 13 || event.keyCode === 13) {
                    $('#formSubmitBtn').trigger('click');
                }
            });
        });
    </script>
@endpush
