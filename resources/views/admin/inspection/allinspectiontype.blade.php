@extends('layouts.app')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Inspection Type Details</h3>
    </div>
  </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <div class="row">
        <div class="col-md-6 my-2">
          <label for="report">{{ __('Show Roles') }}</label>
          <div class="select2-purple">
            <select class="form-control disableinspection" name="roles" id="roles" multiple="multiple" data-dropdown-css-class="select2-purple">
              @if(!empty($roles) && count($roles) != 0)
              @foreach($roles as $key=>$value)
              <option value="{{encrypt($key)}}" {{(!empty($disableinspectionroles)) ? (in_array($key,json_decode($disableinspectionroles,true))) ? 'selected' : '' : '' }}>{{__($value)}}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <label for="report">{{ __('Show User') }}</label>
          <div class="select2-purple">
            <select class="form-control disableinspection" name="users" id="users" multiple="multiple" data-dropdown-css-class="select2-purple">
              @if(!empty($user) && count($user) != 0)
              @foreach($user as $key=>$value)
              <option value="{{encrypt($key)}}" {{(!empty($disableinspectionusers)) ? (in_array($key,json_decode($disableinspectionusers,true))) ? 'selected' : '' : ''  }}>{{__($value)}}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
      <table id="inspectiontable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Created At</th>
            <th>Sno</th>
            <th>Name</th>
            <th>Description</th>
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
  var disableinspection = $('.disableinspection').select2({
    placeholder: "Assign Inspector",
    multiple: true,
  });
  disableinspection.on('select2:selecting', function(sel) {
    var show = "disableinspection" + $(this).attr("id");
    $(this).find("option[value=" + sel.params.args.data.id + "]").each(function(e) {
      element = $(this);
      var insid = element.val();
      if (insid.length) {
        Swal.fire({
          title: 'Are you sure want to assign Test Inspector?',
          text: "Agency and inspector will be immediately notified!",
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
              url: 'disableshow',
              data: {
                id: insid,
                show: show,
                action : "add",
              },
              dataType: 'json',
              success: function(data) {
                toastr.success(data.msg);
                requesttable.ajax.reload();
              },
              error: function(xhr) {
                if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                  toastr.error(xhr.responseJSON.msg);
                }
              }
            });
          } else {
            $(".disableinspection option[value='" + insid + "']").prop('selected', false).trigger('change.select2');
          }
        });
      }
    });
  });

  disableinspection.on('select2:unselecting', function(sel) {
    var show = "disableinspection" + $(this).attr("id");
    $(this).find("option[value=" + sel.params.args.data.id + "]").each(function(e) {
      element = $(this);
      var insid = element.val();
      if (insid.length) {
        Swal.fire({
          title: 'Are you sure want to assign Test Inspector?',
          text: "You will be able to revert this!",
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
              url: 'disableshow',
              data: {
                id: insid,
                show: show,
                action : "remove",
              },
              dataType: 'json',
              success: function(data) {
                toastr.success(data.msg);
                requesttable.ajax.reload();
              },
              error: function(xhr) {
                if (xhr.status == 422 && xhr.responseJSON.msg.length) {
                  toastr.error(xhr.responseJSON.msg);
                }
              }
            });
          }
          else {
            $(".disableinspection option[value='" + insid + "']").prop('selected', false).trigger('change.select2');
          }
        });
      }
    });
  });
</script>
@endpush