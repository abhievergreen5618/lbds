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
                        <option value="pending" {{($status == "pending") ? 'selected' : ''}}>Pending</option>
                        <option value="assigned"  {{($status == "assigned") ? 'selected' : ''}}>Assigned</option>
                        <option value="scheduled"  {{($status == "scheduled") ? 'selected' : ''}}>Scheduled</option>
                        <option value="underreview"  {{($status == "underreview") ? 'selected' : ''}}>Submitted for Review</option>
                        <option value="completed"  {{($status == "completed") ? 'selected' : ''}}>Completed</option>
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
      <table id="companyrequesttable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Type</th>
            <th>Applicant</th>
            <th>Address</th>
            <th>City</th>
            <th>ZipCode</th>
            <th>Added At</th>
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
var companyrequesttable = $('#companyrequesttable').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "companyrequestdetails",
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
            { "width": "30%", "targets": 5 }
        ],
        "columns": [
            {
                "data": "inspectiontype",
            },
            {
                "data": "applicantname",
            },
            {
                "data": "address",
            },
            {
                "data": "city",
            },
            {
                "data": "zipcode",
            },
            {
                "data": "created_at",
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
                companyrequesttable.ajax.reload();
            });
        });
</script>
@endpush