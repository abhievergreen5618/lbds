@push('header_extras')
<style>
    .popover-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-pop {
        font-size: 35px;
    }

    .fc-daygrid-event.fc-daygrid-dot-event.fc-event.fc-event-start.fc-event-end.fc-event-future {
        background: palegoldenrod !important;
    }

    .fc-header-toolbar:nth-child(3) {
            display: block;
    }

    @media (min-width: 400px) and (max-width: 600px)
    {
        .fc-daygrid-day
        {
            position: relative;
        }
        .fc-daygrid-day-events
        {
            top: 50%;
            transform: translate(2px, -5px);
            overflow: hidden;
            height: 21px;
        }
        .fc .fc-header-toolbar .fc-toolbar-chunk:nth-child(3) {
            display: none !important;
        }
    }

    @media (min-width: 300px) and (max-width: 400px){
        .fc-daygrid-day
        {
            position: relative;
        }
        .fc-daygrid-day-events
        {
            top: 50%;
            transform: translate(2px, -5px);
            overflow: hidden;
            height: 21px;
        }
        .fc .fc-header-toolbar .fc-toolbar-chunk:nth-child(3) {
            display: !important;
        }
    }
    @media (min-width: 300px) and (max-width: 600px){
        .fc-daygrid-day
        {
            position: relative;
        }
        .fc-daygrid-day-events
        {
            top: 50%;
            transform: translate(2px, -5px);
            overflow: hidden;
            height: 21px;
        }
        .fc .fc-header-toolbar .fc-toolbar-chunk:nth-child(3) {
            display: !important;
        }
    }
</style>
@endpush
@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Job Calender') }}</h3>
        </div>
        <div class="card-body p-0" id="maincalender" data-id="{{(Auth::user()->hasRole('admin')) ? 'all' : encrypt(Auth::user()->id) }}">
            @role('admin')
            <div class="row">
                <div class="col-lg-6">
                    <div class="my-2 px-2 ml-auto">
                        <label for="jobins">{{ __('Select Agency') }}</label>
                        <select class="form-control" name="jobagency" id="jobagency">
                            <option value="all">All</option>
                            @forelse($agencylist as $key=>$value)
                            <option value="{{encrypt($key)}}">{{__($value)}}</option>
                            @empty
                            <option value="">No Agency Founded</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="my-2 px-2 ml-auto">
                        <label for="jobins">{{ __('Select Inspector') }}</label>
                        <select class="form-control" name="jobins" id="jobins">
                            <option value="all">All</option>
                            @forelse($inslist as $key=>$value)
                            <option value="{{encrypt($key)}}">{{__($value)}}</option>
                            @empty
                            <option value="">No Inspector Founded</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
            @endrole
            <div id="calendar"></div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
@endsection

@push('footer_extras')
<script>
    $(function() {

        var currentoption = $("#maincalender").attr("data-id");

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            dayMaxEvents: true,
            selectable: true,
            themeSystem: 'bootstrap',
            eventSources: function(info, successCallback, failureCallback) {
                let start = moment(info.start.valueOf()).format('YYYY-MM-DD');
                let end = moment(info.end.valueOf()).format('YYYY-MM-DD');
                let filter = currentoption;
                jQuery.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'admininspectorevents',
                    dataType: 'json',
                    data: {
                        'filter': filter,
                        'start': start,
                        'end': end,
                    },
                    success: function(doc) {
                        var events = [];
                        if (!!doc.events) {
                            $.map(doc.events, function(r) {
                                start = new Date(r.scheduled_at + ' ' + r.schedule_time);
                                end = new Date(r.scheduled_at + ' ' + r.schedule_time);
                                events.push({
                                    id: r.id,
                                    title: r.applicantname,
                                    start: start,
                                    end: end,
                                    extendedProps: {
                                        inspectorname: r.name,
                                        link: "<a href='" + r.link + "' target='blank'>View Request</a>",
                                    },
                                    description: "at " + r.address + "<br>" + r.city + ", " + r.state + ", " + r.zipcode,
                                });
                            });
                        }
                        successCallback(events);
                    }
                });
            },
            eventDidMount: function(info) {
                element = $(info.el);
                element.popover({
                    html: true,
                    title: "<h3>" + info.event.title + "</h3>" + "<a class='ml-2 close close-pop'>&times;</a>",
                    content: info.event.extendedProps.description + "<br>" + "Inspector: " + info.event.extendedProps.inspectorname + "<br>" + info.event.extendedProps.link,
                });
            }
        });

        calendar.render();

        var jobins = $('#jobins,#jobagency').select2({
            placeholder: "Select",
        });

        jobins.on('select2:selecting', function(sel) {
            var name = $(this).attr("name");
            $(this).find("option[value=" + sel.params.args.data.id + "]").each(function(e) {
                element = $(this);
                var id = $(this).val();
                if (id.length) {
                    var selectid = (name == "jobagency") ? "jobins" : "jobagency";
                    $('#'+selectid).val("all").trigger('change');
                    currentoption = id;
                    calendar.refetchEvents();
                }
            });
        });

        $(document).on('click', '.close-pop', function() {
            var id = $(this).parent().parent().attr("id");
            $("[aria-describedby='" + id + "']").click();
            $(this).parent().parent().remove();
        });
    })
</script>
@endpush