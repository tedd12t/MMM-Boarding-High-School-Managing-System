<!-- Academic Calendar Professional Suite -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<style>
    /* Premium Calendar Container */
    .calendar-card {
        background: #ffffff;
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }

    /* Reskinning FullCalendar v3 Buttons */
    .fc-button {
        background: #f1f5f9 !important;
        border: 1px solid #e2e8f0 !important;
        color: #475569 !important;
        box-shadow: none !important;
        text-shadow: none !important;
        border-radius: 10px !important;
        padding: 8px 16px !important;
        height: auto !important;
        font-weight: 600 !important;
        text-transform: capitalize !important;
        transition: all 0.2s ease !important;
    }

    .fc-state-active {
        background-color: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
    }

    .fc-button:hover {
        background: #e2e8f0 !important;
    }

    /* Modernizing Header */
    .fc-toolbar {
        margin-bottom: 2rem !important;
        display: flex;
        align-items: center;
    }

    .fc-toolbar h2 {
        font-weight: 800 !important;
        color: #0f172a !important;
        letter-spacing: -1px !important;
        font-size: 1.5rem !important;
    }

    /* Grid Styling */
    .fc-head-container {
        border-radius: 12px !important;
        overflow: hidden;
    }

    .fc-widget-header {
        background: #f8fafc !important;
        padding: 12px 0 !important;
        text-transform: uppercase !important;
        font-size: 0.75rem !important;
        letter-spacing: 1px !important;
        color: #64748b !important;
        border: 1px solid #f1f5f9 !important;
    }

    .fc-day-number {
        padding: 10px !important;
        font-weight: 700 !important;
        color: #94a3b8 !important;
    }

    /* Event Styling */
    .fc-event {
        border: none !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        background: #3b82f6 !important; /* Cyber Blue */
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2) !important;
    }

    /* Toastr Customization */
    #toast-container > .toast-success {
        background-color: #0f172a !important; /* Slate Theme */
        border-radius: 12px !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2) !important;
    }
</style>

<div class="calendar-card">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-calendar-event text-primary me-2"></i> School Schedule
        </h5>
        @if($editable == 'true')
        <span class="badge bg-soft-primary text-primary border border-primary px-3 rounded-pill">
            <i class="bi bi-pencil-square me-1"></i> Management Mode
        </span>
        @endif
    </div>
    
    <div id='full_calendar_events'></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#full_calendar_events').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            // Height control for 4GB RAM stability
            height: {{($editable == 'true')?650:"auto"}},
            groupByResource: true,
            defaultView: 'month',
            editable: {{$editable}},
            eventLimit: true,
            events: SITEURL + '/calendar-event',
            displayEventTime: true,
            selectable: {{$selectable}},
            selectHelper: {{$selectable}},
            
            // Interaction Logic (Kept Original)
            select: function (event_start, event_end) {
                var event_name = prompt("Enter Event Title:");
                if (event_name) {
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + "/calendar-crud-ajax",
                        data: {
                            title: event_name,
                            start: event_start,
                            end: event_end,
                            type: 'create'
                        },
                        type: "POST",
                        success: function (data) {
                            displayMessage("Event Successfully Scheduled");
                            calendar.fullCalendar('renderEvent', {
                                id: data.id,
                                title: event_name,
                                start: event_start,
                                end: event_end
                            }, true);
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            
            eventResize: function (event, delta) {
                var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                $.ajax({
                    url: SITEURL + '/calendar-crud-ajax',
                    data: {
                        title: event.title,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage("Schedule Updated");
                    }
                });
            },

            eventClick: function (event) {
                if({{$selectable}}){
                    var eventDelete = confirm("Remove this event from the academic calendar?");
                    if (eventDelete) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/calendar-crud-ajax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event Removed");
                            }
                        });
                    }
                }
            }
        });
    });

    function displayMessage(message) {
        toastr.success(message, 'Academic Calendar');            
    }
</script>