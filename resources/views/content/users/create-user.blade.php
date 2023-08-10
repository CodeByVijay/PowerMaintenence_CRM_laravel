@extends('layouts/contentNavbarLayout')

@section('title', 'Add New User')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{route('user-users-list')}}">Users</a> /</span> Create User</h4>

    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create New User</h5>
                <div class="card-body">
                  @include('notification')
                    <form action="{{route('createUser')}}" method="post" id="userForm">
                      @csrf
                        <div class="mb-3 row">
                            <label for="html5-text-input" class="col-md-2 col-form-label">Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" value="{{ old('first_name') }}"
                                            name="first_name" id="html5-text-input" placeholder="First Name" />
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" value="{{ old('last_name') }}"
                                            name="last_name" id="html5-text-input" placeholder="Last Name" />
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-email-input" class="col-md-2 col-form-label">Email <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                                    id="html5-email-input" placeholder="Email" />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">Phone <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="tel" name="phone" value="{{ old('phone') }}"
                                    id="html5-tel-input" placeholder="Phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-password-input" class="col-md-2 col-form-label">Password <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-password-toggle">
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password"
                                            id="basic-default-password12"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="basic-default-password2" value="{{ old('password') }}" />
                                        <span id="basic-default-password2" class="input-group-text cursor-pointer"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">User Type <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type1"
                                        value="1" />
                                    <label class="form-check-label" for="user_type1">Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type2"
                                        value="2" />
                                    <label class="form-check-label" for="user_type2">Staff</label>
                                </div>
                                @error('user_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="html5-tel-input" class="col-md-2 col-form-label">Status <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-10">

                                <div class="form-check form-check-inline mt-3">
                                    <input class="form-check-input" type="radio" name="user_status" id="user_status1"
                                        value="1" checked />
                                    <label class="form-check-label" for="user_status1">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="user_status" id="user_status2"
                                        value="0" />
                                    <label class="form-check-label" for="user_status2">Inactive</label>
                                </div>

                                @error('user_status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                {{-- <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
                      </div> --}}
                            </div>
                        </div>

                        <div class="mb-3" style="text-align: center;">
                            <button type="button" class="btn btn-warning" id="formSubmitBtn">Create User</button>
                        </div>
                    </form>
                </div>
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
              let form = $('#userForm')
              setTimeout(() => {
                form.submit();
              }, 900);
            });

            $('#userForm').on('keypress', function(event) {
                if (event.which === 13 || event.keyCode === 13) {
                    $('#formSubmitBtn').trigger('click');
                }
            });
        });
    </script>
@endpush
