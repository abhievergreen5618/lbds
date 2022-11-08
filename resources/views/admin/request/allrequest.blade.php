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
      <div class="table-responsive">
        <table id="requesttable" class="table table-bordered table-striped" cellspacing="0" >
          <thead>
            <tr>
              <th>Request ID</th>
              <th>Agency</th>
              <th>Applicant</th>
              <th>Location</th>
              <th>Inspection Type</th>
              <th>Added At</th>
              <th>Assigned Inspector</th>
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
</div>
@endsection