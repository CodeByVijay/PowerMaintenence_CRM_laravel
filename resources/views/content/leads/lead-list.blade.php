@extends('layouts/contentNavbarLayout')

@section('title', 'Leads List')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Leads /</span> Leads List</h4>

    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="flex" style="display: flex;justify-content: space-between;">
                    <h5 class="card-header">Leads List</h5>
                    <button type="button" style="border: none;outline: none;background-color: #ffffff; margin-right:20px;"><a
                            href="{{ route('lead-create-new') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Add
                            Lead</a></button>
                </div>
                <div class="card-body" style="padding: 0.5rem 1.5rem !important;">
                    @include('notification')

                    @if (auth()->user()->access_type == 1)
                        <div class="dropDown mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="leadAssignUsers" class="form-label">Choose Employee for Assign Lead</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <select id="leadAssignUsers" name="leadAssignUsers" class="select2 form-select">
                                                <option value="" selected>Select Employee</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->first_name . ' ' . $user->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-primary" id="assignLeads">Assign
                                                Lead</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-flush-spacing leadList text-center">
                            <thead>
                                <tr>
                                    <th>
                                        <input class="form-check-input" type="checkbox" id="masterCheckBox"
                                            style="width: 20px !important; height: 20px !important;">
                                    </th>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">A/C Type</th>
                                    <th class="text-center">PostCode</th>
                                    <th class="text-center">Created On</th>
                                    <th class="text-center">Lead Source</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Callback</th>
                                    <th class="text-center">Utilities</th>
                                    <th class="text-center">Modified By</th>
                                    <th class="text-center">Assigned To</th>
                                    <th class="text-center">Modified Date</th>
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
            table = $('.leadList').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('leadList') }}",
                fixedColumns: {
                    left: 1,
                    right: 1
                },
                paging: true,
                scrollCollapse: true,
                scrollX: true,
                columns: [{
                        data: 'checkBox',
                        name: 'checkBox',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'homePhone',
                        name: 'homePhone'
                    },
                    {
                        data: 'ac_type',
                        name: 'ac_type',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'postcode',
                        name: 'postcode',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'created_on',
                        name: 'created_on',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'leadSource',
                        name: 'leadSource',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'lead_status',
                        name: 'lead_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'callback',
                        name: 'callback',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'utilities',
                        name: 'utilities',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'modified_by',
                        name: 'modified_by',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'assign_to',
                        name: 'assign_to',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'modified_date',
                        name: 'modified_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                success: function(data) {
                    // Data retrieval successful
                    console.log(data, "success"); // Output the retrieved data to the console
                },
                error: function(xhr, textStatus, error) {
                    // Data retrieval failed
                    console.log(xhr.responseText, "error"); // Output the error message to the console
                }
            });

        });

        $(document).ready(function() {
            $('#masterCheckBox').on('click', function(e) {
                if ($(this).is(':checked', true)) {
                    $(".singlecheckbox").prop('checked', true);
                } else {
                    $(".singlecheckbox").prop('checked', false);
                }
            });


            $('#assignLeads').on('click', function() {
                let user_id = $('#leadAssignUsers option:selected').val()
                let user_name = $('#leadAssignUsers option:selected').text()
                if (user_id === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select employee!',
                    })
                    return false;
                }

                var allLeads = [];
                $(".singlecheckbox:checked").each(function() {
                    allLeads.push($(this).attr('data-id'));
                });

                if (allLeads.length <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select at least one lead!',
                    })
                    return false;
                } else {
                    // console.log(allVals, user_id, "data")
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Assign selected leads to " + user_name + "!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, assign it!'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('lead-assign') }}",
                            data: {
                                "lead_ids": allLeads,
                                'user_id': user_id
                            },
                            success: function(response) {
                                // console.log(response, "res")
                                Swal.fire(
                                    'Success!',
                                    response.msg + " to" + user_name,
                                    'success'
                                )
                                $('#leadAssignUsers').val('').trigger('change');
                                $("#masterCheckBox").prop('checked', false);
                                table.ajax.reload(null, false);
                            }
                        });
                      }
                    });
                }
            })
        });





        // function statusChange(user_id) {
        //     Swal.fire({
        //         title: 'Are you sure?',
        //         text: "You change status!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, change it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.ajax({
        //                 type: "post",
        //                 url: "{{ route('userStatusChange') }}",
        //                 data: {
        //                     "user_id": user_id,
        //                 },
        //                 success: function(response) {
        //                     if (response.status === 'success') {
        //                         Swal.fire(
        //                             'Updated!',
        //                             'User status successfully updated.',
        //                             'success'
        //                         )
        //                         table.ajax.reload(null, false);
        //                     }
        //                 }
        //             });
        //         }else{
        //           table.ajax.reload(null, false);
        //         }

        //     })
        // }

        function leadDelete(lead_id) {
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
                        url: "{{ route('leadDelete') }}",
                        data: {
                            "lead_id": lead_id,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Lead has been deleted.',
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
