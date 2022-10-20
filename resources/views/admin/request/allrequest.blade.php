@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <h3 class="card-title">Request Details</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <table id="requesttable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Agency</th>
            <th>Applicant</th>
            <th>Location</th>
            <th>Inspection Type</th>
            <th>Added At</th>
            <th>Assigned Inspector</th>
            <th>status</th>
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
