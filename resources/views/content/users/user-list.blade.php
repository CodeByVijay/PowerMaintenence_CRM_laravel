@extends('layouts/contentNavbarLayout')

@section('title', 'User List')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> Users List</h4>

    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="flex" style="display: flex;justify-content: space-between;">
                    <h5 class="card-header">Users List</h5>
                    <button type="button" style="border: none;outline: none;background-color: #ffffff;margin-right: 20px;"><a
                            href="{{ route('user-create-new') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Add
                            User</a></button>
                </div>


                <div class="card-body">
                    @include('notification')

                    <div class="table-responsive">
                        <table class="table table-hover table-flush-spacing userList text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">First Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script type="text/javascript">
        let table;
        $(function() {

            table = $('.userList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('userList') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'access_type',
                        name: 'access_type',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

        });


        function statusChange(user_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You change status!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('userStatusChange') }}",
                        data: {
                            "user_id": user_id,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Updated!',
                                    'User status successfully updated.',
                                    'success'
                                )
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }else{
                  table.ajax.reload(null, false);
                }

            })
        }

        function userDelete(user_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('userDelete') }}",
                        data: {
                            "user_id": user_id,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                                table.ajax.reload(null, false);
                            }
                        }
                    });
                }

            })
        }
    </script>
@endpush
