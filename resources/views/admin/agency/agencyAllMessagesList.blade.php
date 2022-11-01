@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <div class="float-lg-left">
          <h3 class="card-title">All Agency Messages</h3>
          </div>
          <div class="float-lg-right">
            <a class="btn btn-success" href="{{ route('chatify') }}">Chat</a>
          </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
  <div class="card">
    <div class="card-body pt-2">
      <table id="agencyMessages" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Read</th>
            <th>Messages</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
