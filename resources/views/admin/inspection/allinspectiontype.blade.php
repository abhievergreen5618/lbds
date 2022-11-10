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
<div class="modal fade" id="modal-overlay">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="overlay">
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 my-2">
            <label for="report">{{ __('Hide Roles') }}</label>
            <div class="select2-purple">
              <select class="form-control disableinspection" name="roles" id="roles" multiple="multiple" data-dropdown-css-class="select2-purple">
              </select>
            </div>
          </div>
          <div class="col-md-12 my-2">
            <label for="report">{{ __('Hide User') }}</label>
            <div class="select2-purple">
              <select class="form-control disableinspection" name="users" id="users" multiple="multiple" data-dropdown-css-class="select2-purple">
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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
    var inspectionid = $(this).attr("data-id");
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
                inspectionid : inspectionid,
                action: "add",
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
    var inspectionid = $(this).attr("data-id");
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
                action: "remove",
                inspectionid : inspectionid,
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
</script>
@endpush