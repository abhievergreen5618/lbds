@push('header_extras')
<style>
    .tooltip {
        position: absolute;
        z-index: 9999;
        background: #FFC107;
        color: black;
        width: 150px;
        border-radius: 3px;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        padding: 10px;
        text-align: center;
    }

    .style5 .tooltip {
        background: #1E252B;
        color: #FFFFFF;
        max-width: 200px;
        width: auto;
        font-size: .8rem;
        padding: .5em 1em;
    }

    .popper .popper__arrow,
    .tooltip .tooltip-arrow {
        width: 0;
        height: 0;
        border-style: solid;
        position: absolute;
        margin: 5px;
    }

    .tooltip .tooltip-arrow,
    .popper .popper__arrow {
        border-color: #FFC107;
    }

    .style5 .tooltip .tooltip-arrow {
        border-color: #1E252B;
    }

    .popper[x-placement^="top"],
    .tooltip[x-placement^="top"] {
        margin-bottom: 5px;
    }

    .popper[x-placement^="top"] .popper__arrow,
    .tooltip[x-placement^="top"] .tooltip-arrow {
        border-width: 5px 5px 0 5px;
        border-left-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        bottom: -5px;
        left: calc(50% - 5px);
        margin-top: 0;
        margin-bottom: 0;
    }

    .popper[x-placement^="bottom"],
    .tooltip[x-placement^="bottom"] {
        margin-top: 5px;
    }

    .tooltip[x-placement^="bottom"] .tooltip-arrow,
    .popper[x-placement^="bottom"] .popper__arrow {
        border-width: 0 5px 5px 5px;
        border-left-color: transparent;
        border-right-color: transparent;
        border-top-color: transparent;
        top: -5px;
        left: calc(50% - 5px);
        margin-top: 0;
        margin-bottom: 0;
    }

    .tooltip[x-placement^="right"],
    .popper[x-placement^="right"] {
        margin-left: 5px;
    }

    .popper[x-placement^="right"] .popper__arrow,
    .tooltip[x-placement^="right"] .tooltip-arrow {
        border-width: 5px 5px 5px 0;
        border-left-color: transparent;
        border-top-color: transparent;
        border-bottom-color: transparent;
        left: -5px;
        top: calc(50% - 5px);
        margin-left: 0;
        margin-right: 0;
    }

    .popper[x-placement^="left"],
    .tooltip[x-placement^="left"] {
        margin-right: 5px;
    }

    .popper[x-placement^="left"] .popper__arrow,
    .tooltip[x-placement^="left"] .tooltip-arrow {
        border-width: 5px 0 5px 5px;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        right: -5px;
        top: calc(50% - 5px);
        margin-left: 0;
        margin-right: 0;
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
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 offset-lg-6">
                    <div class="my-2 px-2 ml-auto">
                        <div class="d-flex justify-content-around align-items-center">
                            <label for="jobins">{{ __('Select Inspector') }}</label>
                            <div class="w-75">
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
                </div>
            </div>
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

        var currentoption = "all";

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
                                start = new Date(r.schedule_at + ' ' + r.schedule_time);
                                end = new Date(r.schedule_at + ' ' + r.schedule_time);
                                events.push({
                                    id: r.id,
                                    title: r.applicantname,
                                    start: start,
                                    end: end,
                                    extendedProps: {
                                        inspectorname : r.name,
                                        link : "<a href='#'>View Request</a>",
                                    },
                                    description: "at "+r.address+"<br>"+r.city+", "+r.state+", "+r.zipcode,
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
                    html:true,
                    animation: true,
                    delay: 300,
                    title: "<h3>"+info.event.title+"<h3>"+"<button type='button' id='close' class='close' onclick='$(&quot;#example&quot;).popover(&quot;hide&quot;);'>&times;</button>",
                    content: info.event.extendedProps.description+"<br>"+"Inspector: "+info.event.extendedProps.inspectorname+"<br>"+info.event.extendedProps.link,
                    placement:'top',
                });
            }
        });

        calendar.render();

        var jobins = $('#jobins').select2({
            placeholder: "Select",
        });

        jobins.on('select2:selecting', function(sel) {
            $(this).find("option[value=" + sel.params.args.data.id + "]").each(function(e) {
                element = $(this);
                var id = $(this).val();
                if (id.length) {
                    currentoption = id;
                    calendar.refetchEvents();
                }
            });
        });
    })
</script>
@endpush