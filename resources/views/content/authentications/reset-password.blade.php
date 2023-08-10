@extends('layouts/blankLayout')

@section('title', 'Reset Password')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
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
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <img src="{{ asset('assets/img/logo.png') }}" alt="main-logo">
            </a>
          </div>
          <!-- /Logo -->
          @include('notification')

          <h5 class="mb-2">Welcome to {{config('variables.templateName')}}! 👋</h5>
          <p class="mb-4">Please reset your password.</p>

          <form id="resetPasswordForm" class="mb-3" action="{{route('reset_password_post')}}" method="post">
            @csrf
              <input type="hidden" class="form-control" id="email" name="email" name="email-username" placeholder="Enter your email" autofocus value="{{$checkToken->email}}">
              @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            <div class="mb-3 form-password-toggle">
              <div class="input-group input-group-merge">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-describedby="password" value="{{old('password')}}"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('password')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="input-group input-group-merge">
                <input type="password" id="confirm_password" name="con_password" class="form-control" placeholder="Confirm Password" aria-describedby="password" value="{{old('con_password')}}"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('con_password')
              <span class="text-danger">{{ $message }}</span>
          @enderror
            </div>

            <div class="mb-3">
              <button class="btn btn-warning w-100" type="button" id="formSubmitBtn">Reset Password</button>
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
            $('#formSubmitBtn').on('click', function() {
              let btn = $(this)
              btn.attr("disabled","disabled")
              btn.html(`Please wait <i class="fa fa-spinner fa-pulse fa-fw"></i>`)
              let form = $('#resetPasswordForm')
              setTimeout(() => {
                form.submit();
              }, 900);
            });

            $('#resetPasswordForm').on('keypress', function(event) {
                if (event.which === 13 || event.keyCode === 13) {
                    $('#formSubmitBtn').trigger('click');
                }
            });
        });
    </script>
@endpush
