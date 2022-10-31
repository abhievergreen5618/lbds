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
            themeSystem: 'bootstrap',
            events: function(start, end, timezone, callback) {
                console.log(start);
                jQuery.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'admininspectorevents',
                    dataType: 'json',
                    data: {
                        // start: start.moment().format(),
                        // end: end.moment().format(),
                    },
                    success: function(doc) {
                        var events = [];
                        // if (!!doc.result) {
                        //     $.map(doc.result, function(r) {
                        //         events.push({
                        //             id: r.id,
                        //             title: r.title,
                        //             start: r.date_start,
                        //             end: r.date_end
                        //         });
                        //     });
                        // }
                        callback(events);
                    }
                });
            }
        });

        calendar.render();
        // $('#calendar').fullCalendar()
    })
</script>
@endpush