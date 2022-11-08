@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">All Pending Agencies Details</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body pt-2">
                <table id="agencyApprovaltable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>Company Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Zip Code</th>
                            <th>Approval Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
