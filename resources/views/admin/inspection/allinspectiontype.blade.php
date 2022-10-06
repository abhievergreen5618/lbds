@extends('layouts.app')

@section('content')
<div class="col-lg-12">
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Inspection Type</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped" id="inspectiontable">
                  <thead>
                    <tr>
                      <th>SNo</th>
                      <th>Name</th>
                      <th>Description</th>
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