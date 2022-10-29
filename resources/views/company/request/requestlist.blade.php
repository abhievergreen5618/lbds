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
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
