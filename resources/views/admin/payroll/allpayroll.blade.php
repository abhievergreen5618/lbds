@extends('layouts.app')

@section('content')


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
    <div class="card-body">
    <div class="pl-4 pr-4 p-3 row">
    <div class="col-12">
      <h3 class="card-title">Payroll Tracker</h3>
    </div>
        <div class="col-6 mt-2">
            <h6 class="text-grey">Seleted Job Income :   $ <strong class="text-success" id="income">0</strong></h6>
            <h6 class="text-grey">Seleted Inspector Income : $ <strong class="text-danger" id="payment">0</strong></h6>
            <h6 class="text-grey">Profit : $ <strong id="profit" class="text-info">0</strong></h6>
        </div>
      </div>
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
              <th>Select Job</th>
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
        "order": [1, 'desc'],
        
        "columns": [
            {
                "data": "checkbox",
            },
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

payrolltable.on('click', '.selectbox', function () {
  var allselectbox = $(".selectbox");
  if(allselectbox.length)
  {
    var selectedjobincome = 0;
    var selectedinspectorincome = 0;
    var profit = 0;
    $.each(allselectbox,(key,value)=>{
      var income = $(value).closest("tr").find("[name='income']").val().length ? parseInt($(value).closest("tr").find("[name='income']").val()) : 0; 
      var inspectorfee = $(value).closest("tr").find("[name='ins_fee']").val().length ? parseInt($(value).closest("tr").find("[name='ins_fee']").val()) : 0; 
      if($(value).is(":checked"))
      {
        selectedjobincome = parseInt(selectedjobincome+income); 
        selectedinspectorincome = parseInt(selectedinspectorincome+inspectorfee);
        var tempprofit = parseInt(inspectorfee-income);
        profit = profit+tempprofit;
        $(value).attr("added","true");
      }
      else if(!$(value).is(":checked") && typeof $(value).attr("added") != "undefined" && $(value).attr("added").length) 
      {
        $(value).removeAttr("added");
      }
    });
    $("#payment").text(selectedjobincome);
    $("#income").text(selectedinspectorincome);
    $("#profit").text(profit);
  }
});
}); 
</script>
@endpush