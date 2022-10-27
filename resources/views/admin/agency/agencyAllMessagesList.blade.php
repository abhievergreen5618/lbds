@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
          <h3 class="card-title">All Agency Messages</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
    {{-- <div class="row">
        <div class="form-group">
           <label for="status">Status:</label>
           <select id="status" class="form-control">
               <option disabled>--Select Status--</option>
               <option value="active">Active</option>
               <option value="deactive">Deactive</option>
           </select>
        </div> --}}
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
