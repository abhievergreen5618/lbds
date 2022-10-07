@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <h3 class="card-title">Send Invoice Details</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <table id="sendinvoicetable" class="table table-bordered table-striped">
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