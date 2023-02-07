@extends('layouts.app')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Payroll Tracker</h3>
    </div>
  </div>
</div>

<div class="col-lg-12">
  <div class="card card-primary collapsed-card">
    <div class="card-header">
      <h3 class="card-title">Filter</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-plus"></i>
        </button>
        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button> -->
      </div>
    </div>
    <div class="card-body" style="display: none;" >
    <form id='filterform'>
      <div class="row">
        <div class="col-lg-4">
          <div class="my-2 px-2 ml-auto">
            <label for="assign_ins">{{ __('Select Inspector') }}</label>
            <select class="form-control" name="assign_ins" id="assign_ins">
              <option value="all">All</option>
              @forelse($inspector as $key=>$value)
              <option value="{{encrypt($key)}}">{{__($value)}}</option>
              @empty
              <option value="">No Inspector Founded</option>
              @endforelse
            </select>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="my-2 px-2 ml-auto">
            <label for="assign_ins">{{ __('Pay Range') }}</label>
            <input type='text'   data-id='daterange' id='daterange' name='date_range'class='pay_rangedate form-control' placeholder='dd-mm-yyyy' value=''>
          </div>
        </div>

        <div class="col-lg-4">
        <!-- <div class="my-2 px-2 ml-auto"> -->
        <button type="submit" class="btn btn-primary" style="margin-top: 37px;">{{ __('Apply') }}</button>
        <!-- </div> -->
        </div>
      </div>
    </form>
    </div>
  </div>

</div>

<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <div class="table-responsive">
        <table id="payrolltable" class="table table-bordered table-striped" cellspacing="0">
          <thead>
            <tr>
              <th>Assigned Inspector</th>
              <th>Agency</th>
              <th>Location</th>
              <th>Inspection Type</th>
              <th>Job Income</th>
              <th>Inspector Pay</th>
              <th>Pay Range</th>
              <th>Pay Date</th>
              <th>Is Paid</th>
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
  $(document).ready(function() {
    $('#assign_ins').select2();

 // debugger;
 function date_range() {
        $('.pay_rangedate').attr("placeholder", "MM/DD/YYYY").daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
               
            },
          
        });
        $('.pay_rangedate').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('.pay_rangedate').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('.daterangesingle').attr("placeholder", "MM/DD/YYYY").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                dateFormat: 'MM/DD/YYYY',
                cancelLabel: 'Clear',
            },
            autoUpdateInput: false,
        },
        );
        $('.daterangesingle').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY'));
            $(this).val(picker.endDate.format('MM/DD/YYYY'))
        });
        $('.daterangesingle').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    }

    // payrolltrack table
 


  var payrolltable = $('#payrolltable').DataTable({
        "preDrawCallback": function (settings) {
            setTimeout(function () {
                date_range();
            }, 1000);
        },
        "processing": true,
        "serverSide": true,
        "scrollX": true,
        "ajax": {
            "url": "payrolldetails",
            "type": "POST",
            'beforeSend': function (request) {
                request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
            },
            "data": function ( d ) {
         return $.extend( {}, d, {
           "assign_ins": $("#assign_ins").val(),
           "pay_range": $("#daterange").val()
         } );
       }
        },
        "columnDefs": [
            { "className": "dt-center", "width": "9%", "targets": "_all" },
        ],
        "order": [0, 'desc'],
        
        "columns": [
            {
                "data": "assigned_ins",
            },
            {
                "data": "company_id",
            },
            {
                "data": "address",
            },
            {
                "data": "inspectiontype",
            },
            {
                "data": "ins_fee",
            },
            {
                "data": "income",
            },
            {
                "data": "pay_range",
                "width": '100px',

            },
            {
                "data": "pay_date",
            },
            {
                "data": "payment_status",
            },
            {
                "data": "action",
            },
        ],
    });
    $("#filterform").submit(function(e){
       e.preventDefault();
       payrolltable.ajax.reload();
    });

    payrolltable.on('click', '.btn', function () {
        var element = $(this);
        var id = $(this).attr('data-id');

        const data = {};
        var arr = $(this).parent().parent().parent().find('input');
        $.each(arr, function (key, value) {
              var result = ($(value).attr("id") == "payment_status") ? $(value).is(":checked") ? $(value).val() : "unpaid" :  $(value).val();
              payroll_data = $(value).attr("data-id");
              data[payroll_data] = result;
        });


        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {     
              $.ajax({
                  "url": "submit",
                  "type": "POST",
                  "beforeSend": function (request) {
                      request.setRequestHeader("X-CSRF-TOKEN", jQuery('meta[name="csrf-token"]').attr('content'));
                  },
                  "data": {
                      id: id, data: data
                  },
                  dataType: 'json',
                  success: function (data) {
                      console.log(data.msg, data);
                      toastr.success(data.msg);
                      payrolltable.ajax.reload();
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
});
}); 
}); 
</script>
@endpush