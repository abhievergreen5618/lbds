@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <h3 class="card-title">All Inspectors Details</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <table id="inspectortable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Company</th>
            <th>Name</th>
            <th>Color Code</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Status</th>
            <th>License Number</th>
            <th>Area(s) of Services</th>
            <th>Profile</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection