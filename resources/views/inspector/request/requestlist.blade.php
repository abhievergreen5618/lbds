@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <h3 class="card-title">Assigned Requests</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
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
