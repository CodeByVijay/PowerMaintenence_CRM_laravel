@extends('layouts/contentNavbarLayout')

@section('title', 'Calendar')
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <style>
        .modal .modal-header .btn-close {
            margin-top: 0.75rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <!-- Basic -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Full Calendar</h5>
                <div class="card-body" style="padding: 0.5rem 1.5rem !important;">
                    @include('notification')
                    <div id="fullCalendar"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Define the modal -->
    {{-- Model Component --}}
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true"
        style="top: 120px !important">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute;right: 40px;box-shadow: none;"></button>
                </div>
                <div class="modal-body" id="eventModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Model Component End --}}

@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var calendar = $('#fullCalendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay' //agendaDay
                },
                events: {!! json_encode($events) !!},
                // Callback function when an event is clicked
                eventClick: function(event) {
                    var modal = $('#eventModal');
                    var modalBody = $('#eventModalBody');
                    modal.find('.modal-title').text('Note: ' + event.title);
                    var content = '<p>Callback Time: ';
                    if (event.start) {
                        content += event.start.format('DD MMM YYYY hh:mm A');
                    } else {
                        content += 'N/A';
                    }
                    content += '</p>';
                    // content += '<p>End: ';
                    // if (event.end) {
                    //     content += event.end.format('YYYY-MM-DD HH:mm:ss');
                    // } else {
                    //     content += 'N/A';
                    // }
                    // content += '</p>';
                    modalBody.html(content);
                    modal.modal('show'); // Open the modal
                },
                eventTextColor: 'white',
                error: function() {
                    alert('Error fetching events from the server');
                }
            })
        });
    </script>
@endpush
