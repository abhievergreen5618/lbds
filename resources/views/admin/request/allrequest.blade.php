@push("header_extras")
<style>
.dataTables_wrapper td {
  width: 100px !important;
}
</style>
@endpush

@extends('layouts.app')

@section('content')
<div class="col-md-12">
  <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('View All Requests') }}</h3>
        </div>
    <div class="card-body pt-2" id="requeststatusajax" data-status="{{$status}}">
        <div class="col-lg-4 offset-lg-8">
          <div class="my-2 px-2 ml-auto">
              <label for="requeststatus">{{ __('Filter Status: ') }}</label>
              <select class="form-control" name="requeststatus" id="requeststatus">
                  <option value="all">All</option>
                  <option value="pending" {{($status ==  "pending") ? 'selected' : ''}}>Pending</option>
                  <option value="assigned"  {{($status ==  "assigned") ? 'selected' : ''}}>Assigned</option>
                  <option value="scheduled"  {{($status == "scheduled") ? 'selected' : ''}}>Scheduled</option>
                  <option value="underreview"  {{($status == "underreview") ? 'selected' : ''}}>Under-review</option>
                  <option value="completed"  {{($status == "completed") ? 'selected' : ''}}>Completed</option>
                  <option value="cancelled"  {{($status ==  "cancelled") ? 'selected' : ''}}>Cancelled</option>
              </select>
          </div>
      </div>
      <div class="table-responsive">
        <table id="requesttable" class="table table-bordered table-striped" cellspacing="0" >
          <thead>
            <tr>
              <th>Request ID</th>
              <th>Agency</th>
              <th>Applicant</th>
              <th>Location</th>
              <th>Inspection Type</th>
              <th>Added On</th>
              <th>Assigned Inspector</th>
              <th>Status</th>
              <th>Invoiced</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('footer_extras')
<script>
    $(function() {
      function select2call() {
        $('.inspectorlist').select2({
            placeholder: "Assign Inspector",
            tags: true,
        });
        $('.statusdropdown').select2({
            placeholder: "Select Status",
            tags: true,
        });
        $("input[data-bootstrap-switch]").each(function() {
           $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch({
            'state':$(this).prop('checked'),
            'onSwitchChange': function(event, state){
            element = $(this);
            var userid = $(this).attr("data-req-id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be able to revert this!!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    $('.preloader').children().show();
                    $('.preloader').css("height", "100vh");
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        },
                        url: 'invoicestatusupdate',
                        data: {
                            id: userid,
                            state :state
                        },
                        dataType: 'json',
                        success: function (data) {
                            $('.preloader').children().hide();
                            $('.preloader').css("height", "0");
                            toastr.success(data.msg);
                            rolestable.ajax.reload();
                        },
                        error: function (data) {
                            // console.log(data);
                        }
                    });
                }
                else
                {
                    $(this).bootstrapSwitch('state',!state, true);
                }
            });
            },
            })
        });
        });
    }
    
      var status = $("#requeststatusajax").attr("data-status");
      var requesttable = $('#requesttable').DataTable({
        "autoWidth": false,
        responsive: true,
        "preDrawCallback": function (settings) {
            setTimeout(function () {
                select2call();
            }, 1000);
        },
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "requestdetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
            data: function(d){
            d.status = status;
            }
        },
        "columnDefs": [
            { "className": "dt-center","targets": "_all" },
            { width: '20%', targets: 0 },
            { width: '30%', targets: 1 },
            { width: '50%', targets: 2 }
        ],
        "order": [5,'desc'],
        "columns": [
            {
                "data": "unique_request_id",
            },
            {
                "data": "company_id",
            },
            {
                "data": "applicantname",
            },
            {
                "data": "address",
            },
            {
                "data": "inspectiontype",
            },
            {
                "data": "created_at",
            },
            {
                "data": "assigned_inspector",
                "width" : "1000px",
            },
            {
                "data": "status",
            },
            {
                "data": "invoice",
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
                requesttable.ajax.reload();
            });
        });
        requesttable.on('click', '.delete', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'request-delete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        requesttable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    requesttable.on('click', '.complete', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure to Mark it as Completed?',
            text: "You will not be able to revert this action!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'requestcomplete',
                    data: {
                        id: userid
                    },
                    dataType: 'json',
                    success: function (data) {
                        requesttable.ajax.reload();
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
            };
        });
    });
    requesttable.on('click', '.cancel', function () {
        $('#userdetails_processing').show();
        element = $(this);
        var userid = $(this).attr('data-id');
        Swal.fire({
            title: 'Confirmation',
            input: 'textarea',
            inputLabel: 'Are you sure you want to cancel?',
            inputPlaceholder: 'Please write the reason',
            inputAttributes: {
                'aria-label': 'Type your message here'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: 'request-cancel',
                    data: {
                        id: userid,
                        msg: result.value,
                    },
                    dataType: 'json',
                    success: function (data) {
                        toastr.success(data.msg);
                        requesttable.ajax.reload();
                    },
                    error: function (xhr) {
                        if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                            $('.preloader').children().hide();
                            $('.preloader').css("height", "0");
                            toastr.error(xhr.responseJSON.msg);
                        }
                    }
                });
            };
        });
    });
    requesttable.on('select2:selecting', '.inspectorlist', function (sel) {
        $(this).find("option[value=" + sel.params.args.data.id + "]").each(function (e) {
            element = $(this);
            var insid = $(this).val();
            var insname = $(this).text();
            var reqid = $(this).attr('data-req-id');
            if (insid.length && reqid.length) {
                Swal.fire({
                    title: 'Are you sure want to assign ' + ucfirst(insname) + '?',
                    text: "Agency and inspector will be immediately notified!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        $('.preloader').children().show();
                        $('.preloader').css("height", "100vh");
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'inspectorassign',
                            data: {
                                id: insid,
                                reqid: reqid,
                            },
                            dataType: 'json',
                            success: function (data) {
                                $('.preloader').children().hide();
                                $('.preloader').css("height", "0");
                                toastr.success(data.msg);
                                requesttable.ajax.reload();
                            },
                            error: function (xhr) {
                                if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                                    $('.preloader').children().hide();
                                    $('.preloader').css("height", "0");
                                    toastr.error(xhr.responseJSON.msg);
                                }
                            }
                        });
                    }
                    else {
                        $(".inspectorlist option[value='" + insid + "']").prop('selected', false).trigger('change.select2');
                    }
                });
            }
        });
    });
    requesttable.on('select2:selecting', '.statusdropdown', function (sel) {
        var insid = $(this).attr('data-req-id');
        $(this).find("option[value=" + sel.params.args.data.id + "]").each(function (e) {
            element = $(this);
            var status = $(this).val();
            if (insid.length && status.length) {
                Swal.fire({
                    title: 'Are you sure want to change status to ' + ucfirst(status) + '?',
                    text: "You will able to revert!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        $('.preloader').children().show();
                        $('.preloader').css("height", "100vh");
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            url: 'statusupdate',
                            data: {
                                id: insid,
                                status: status,
                            },
                            dataType: 'json',
                            success: function (data) {
                                $('.preloader').children().hide();
                                $('.preloader').css("height", "0");
                                toastr.success(data.msg);
                                requesttable.ajax.reload();
                            },
                            error: function (xhr) {
                                if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                                    $('.preloader').children().hide();
                                    $('.preloader').css("height", "0");
                                    toastr.error(xhr.responseJSON.msg);
                                }
                            }
                        });
                    }
                    else {
                        $(".inspectorlist option[value='" + insid + "']").prop('selected', false).trigger('change.select2');
                    }
                });
            }
        });
    });
    });
      </script>
@endpush