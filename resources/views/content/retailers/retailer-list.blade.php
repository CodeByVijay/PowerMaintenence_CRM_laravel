@extends('layouts/contentNavbarLayout')

@section('title', 'Retailer List')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Retailer /</span> Retailer List</h4>

    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="flex" style="display: flex;justify-content: space-between;">
                    <h5 class="card-header">Retailer List</h5>
                    <button type="button" style="border: none;outline: none;background-color: #ffffff;margin-right: 20px;"><a
                            href="{{ route('retailer-create-new') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Add
                            Retailer</a></button>
                </div>


                <div class="card-body">
                    @include('notification')

                    <div class="table-responsive">
                        <table class="table table-hover table-flush-spacing userList text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Logo</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Energy</th>
                                    <th class="text-center">Broadband</th>
                                    <th class="text-center">Active</th>
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
                ajax: "{{ route('retailerList') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'logo',
                        name: 'logo'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'energy',
                        name: 'energy',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'broadband',
                        name: 'broadband',
                        orderable: false,
                        searchable: false
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


        function statusChange(retailer_id) {
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
                        url: "{{ route('retailerStatusChange') }}",
                        data: {
                            "retailer_id": retailer_id,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Updated!',
                                    'Retailer status successfully updated.',
                                    'success'
                                )
                                table.ajax.reload(null, false);
                            } else {
                                console.log(response)
                            }
                        }
                    });
                } else {
                    table.ajax.reload(null, false);
                }

            })
        }

        function retailerDelete(retailer_id) {
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
                        url: "{{ route('retailerDelete') }}",
                        data: {
                            "retailer_id": retailer_id,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Retailer has been deleted.',
                                    'success'
                                )
                                table.ajax.reload(null, false);
                            } else {
                                console.log(response)
                            }
                        }
                    });
                }

            })
        }

        lightbox.option({
            'resizeDuration': 700,
            'wrapAround': true,
            'maxWidth':500,
            'maxHeight':150
        })
    </script>
@endpush
