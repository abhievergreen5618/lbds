@extends('layouts.app')


@section('content')
<div class="card">
  <div class="card-body">
    <div class="row mb-2">
    <div class="col-sm-6">
        <h4>Users Management</h4>
    </div>
    <div class="col-sm-6">
        <div class="float-right">
        @can('user-create')
        <a class="btn btn-primary" href="{{ route('users.create') }}"> Create New User </a>
        @endcan
        </div>
    </div>
    </div>
    </div>
</div>


<div class="col-lg-12">
    <div class="card">
      <div class="card-body pt-2">
        <table id="userstable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Sno.</th>
              <th>Name</th>
              <th>Email</th>
              <th>Roles</th>
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