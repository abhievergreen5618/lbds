@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
        <div class="row align-items-center">
              <div class="col-lg-4">
                <h3 class="card-title">Request Details</h3>
              </div>
              <div class="col-lg-4 offset-lg-4">
                <div class="my-2 px-2 ml-auto d-flex">
                    <label for="requeststatus">{{ __('Filter Status:') }}</label>
                    <select class="form-control" name="requeststatus" id="requeststatus">
                        <option value="all">All</option>
                        <option value="assigned"  {{($status == "assigned") ? 'selected' : ''}}>Assigned</option>
                        <option value="scheduled"  {{($status == "scheduled") ? 'selected' : ''}}>Scheduled</option>
                        <option value="underreview"  {{($status == "underreview") ? 'selected' : ''}}>Submitted for Review</option>
                        <option value="completed"  {{($status == "completed") ? 'selected' : ''}}>Completed</option>
                        <option value="cancelled"  {{($status ==  "cancelled") ? 'selected' : ''}}>Cancelled</option>
                    </select>
                </div>
              </div>
          </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2" id="requeststatusajax" data-status="{{$status}}">
      <table id="inspectorrequesttable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Agency Info</th>
            <th>Applicant Information</th>
            <th>Property Information</th>
            <th>Detailed Address</th>
            <th>Other Info</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('footer_extras')
<script>
var status = $("#requeststatusajax").attr("data-status");
var inspectorrequesttable = $('#inspectorrequesttable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "inspectorrequestdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
            data: function(d){
            d.status = status;
            }
        },
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" },
        ],
        "columns": [
            {
                "data": "company_id",
            },
            {
                "data": "applicantinformation",
            },
            {
                "data": "address",
            },
            {
                "data": "detailedaddress",
            },
            {
                "data": "otherinfo",
            },
            {
                "data": "status",
            },
            {
                "data": "action",
            },

        ],
    });

var requeststatus = $('#requeststatus').select2({
            placeholder: "Select",
        });
requeststatus.on('select2:selecting', function(sel) {
    var name = $(this).attr("name");
    $(this).find("option[value=" + sel.params.args.data.id + "]").each(function(e) {
        element = $(this);
        var id = $(this).val();
        status = id;
        inspectorrequesttable.ajax.reload();
    });
});



inspectorrequesttable.on('click', '.schedule,.reschedule', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = element.attr('data-id');
        var date = element.attr('data-date');
        var time = element.attr('data-time');
        var status = (element.hasClass("schedule")) ? "schedule" : "reschedule";
        var yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        var html = "<div class='d-flex'><input type='date' class='border p-2 form-control' id='date' value='" + date + "' name='date' min='2022-10-21'><input type='time' class='border p-2 form-control ml-2' id='time' value='" + time + "' name='time'><div>";
        Swal.fire({
            title: 'Reschedule Request',
            html: html,
            confirmButtonText: 'Submit',
            focusConfirm: false,
            preConfirm: () => {
                const redate = Swal.getPopup().querySelector('#date').value
                const retime = Swal.getPopup().querySelector('#time').value
                GivenDate = new Date(redate);
                if (!redate || !retime) {
                    Swal.showValidationMessage(`Please select date and time`)
                }
                else if (!(GivenDate > yesterday)) {
                    Swal.showValidationMessage(`Please select date greater than yesterday`)
                }
                return { date: redate, time: retime }
            }
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'request-reschedule',
                    data: {
                        id: userid,
                        time: result.value.time,
                        date: result.value.date,
                        status: status,
                    },
                    dataType: 'json',
                    success: function (data) {
                        toastr.success(data.msg);
                        inspectorrequesttable.ajax.reload();
                    },
                    error: function (xhr) {
                        if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                            toastr.error(xhr.responseJSON.msg);
                        }
                    }
                });
            }
        })
    });
    inspectorrequesttable.on('click', '.submitreview', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure to Submit for Review to Admin?',
            text: "You will not be able to update the forms once you submit it!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'request-submit-review',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        toastr.success(data.msg);
                        inspectorrequesttable.ajax.reload();
                    },
                    error: function (xhr) {
                        if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                            toastr.error(xhr.responseJSON.msg);
                        }
                    }
                });
            };
        });
    });
</script>
@endpush
