@extends('layouts.app')

@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Inspection Type</h3>
    </div>
    <div class="card-body pt-2">
      <table id="inspectiontable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Sno</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created At</th>
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