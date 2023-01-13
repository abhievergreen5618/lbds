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
      <table id="employeetable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <!-- <th>Address</th> -->
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
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
