@extends('layouts/blankLayout')

@section('title', 'Error - 401')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
<!-- Error -->
<div class="container-xxl container-p-y">
  <div class="misc-wrapper">
    <h2 class="mb-2 mx-2">Unauthorized Access :(</h2>
    <p class="mb-4 mx-2">Oops! 😖 The requested URL not accessible.</p>
    <a href="{{url('/')}}" class="btn btn-primary">Back to home</a>
    <div class="mt-3">
      <img src="{{asset('assets/img/illustrations/401 Error Unauthorized-cuate.png')}}" alt="page-misc-error-light" width="500" class="img-fluid">
    </div>
  </div>
</div>
<!-- /Error -->
@endsection
