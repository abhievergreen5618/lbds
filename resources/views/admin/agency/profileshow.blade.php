@extends('layouts.app')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/profile/').'/'.$data->profile_img }}" alt="User profile picture">
          </div>
          <h3 class="profile-username text-center">{{ucfirst($data->name)}}</h3>

          <p class="text-muted text-center">{{$data->company_name}}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Agency ID:</b> <a class="float-right">{{$data->id}}</a>
            </li>
            <li class="list-group-item">
              <b>Total Requests:</b> <a class="float-right">{{$totalrequest}}</a>
            </li>
            <li class="list-group-item">
              <b>Pending Requests:</b> <a class="float-right">{{$pendingrequest}}</a>
            </li>
            <li class="list-group-item">
              <b>Scheduled Requests:</b> <a class="float-right">{{$scheduledrequest}}</a>
            </li>
            <li class="list-group-item">
              <b>Completed Requests:</b> <a class="float-right">{{$completedrequest}}</a>
            </li>
          </ul>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">About Me</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-building mr-1"></i>Company Name</strong>

          <p class="text-muted">
            {{ $data->company_name }}
          </p>

          <hr>

          <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

          <p class="text-muted">{{$data->company_address}}</p>

          <hr>


          <strong><i class="fa fa-phone-alt mr-1"></i>Contact</strong>

          <p class="text-muted">{{$data->company_phonenumber}}</p>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#pending_requests" data-toggle="tab">Pending Requests</a></li>
            <li class="nav-item"><a class="nav-link" href="#scheduled_requests" data-toggle="tab">Scheduled Requests</a></li>
            <li class="nav-item"><a class="nav-link" href="#completed_requests" data-toggle="tab">Completed Requests</a></li>
            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Notifications Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="#notifications" data-toggle="tab">Send Mail</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="pending_requests">
              <table id="pendingrequesttable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Applicant</th>
                    <th>Location</th>
                    <!-- <th>Inspection Type</th> -->
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- pending request -->
                  @if(!empty($pending_request))
                  @foreach($pending_request as $value)
                  <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->applicantname}}</td>
                    <td>{{$value->address}}</td>
                    <!-- <td>{{$value->inspectiontype}}</td> -->
                    <td class="badge bg-warning">{{$value->status}}</td>
                  </tr>
                  @endforeach
                  @else
                  There is no Request History.
                  @endif
                </tbody>

              </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="scheduled_requests">
              All Scheduled Requests
              <table id="scheduledrequesttable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Applicant</th>
                    <th>Location</th>
                    <!-- <th>Inspection Type</th> -->
                    <th>Scheduled At</th>
                    <th>Assigned Inspector</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- scheduled_request -->
                  @if(!empty($scheduled_request))
                  @foreach($scheduled_request as $value)
                  <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->applicantname}}</td>
                    <td>{{$value->address}}</td>
                    <!-- <td>{{$value->inspectiontype}}</td> -->
                    <td>{{(!empty($value->scheduled_at) ? $value->schedule_at : '')}}</td>
                    <td>{{(!empty($value->assigned_ins) ? $value->schedule_at : '')}}</td>
                    <td  class="badge bg-danger">{{$value->status}}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>There is no Request History.</tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="completed_requests">
              All Completed Requests
              <table id="completedrequesttable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Request ID</th>
                    <th>Applicant</th>
                    <th>Location</th>
                    <!-- <th>Inspection Type</th> -->
                    <th>Added At</th>
                    <th>Assigned Inspector</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- completed request -->
                  @if(!empty($completed_request))
                  @foreach($completed_request as $value)
                  <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->applicantname}}</td>
                    <td>{{$value->address}}</td>
                    <!-- <td>{{$value->inspectiontype}}</td> -->
                    <td>{{$value->completed_at}}</td>
                    <td>{{$value->assigned_ins}}</td>
                    <td class="badge bg-success">{{$value->status}}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>There is no Request History.</tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="settings">
            
                <form class="form-horizontal" id="agencyemailconfiguration" action="{{ route('admin.update.agency-mail') }}" method="POST">
                  @csrf
                <input type="hidden" name="id" value="{{encrypt($data->id )}}">
                {{-- {{dd($data->notification_settings['request_assigned']) }} --}}
                <div class="form-group mb-2 row">
                  <div class="col-md-6">
                    <label for="notification_settings">{{ __('Request Assigned') }}</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" name="notification_settings[request_assigned]" data-bootstrap-switch="" data-off-color="danger"  data-on-color="success" value="on" 
                    {{!empty($data->notification_settings) ? (array_key_exists('request_assigned',$data->notification_settings))? "checked" :"" :"checked"  }}>
                  </div>
                </div>
                <div class="form-group mb-2 row">
                  <div class="col-md-6">
                    <label for="notification_settings">{{ __('Request Scheduled') }}</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" name="notification_settings[request_scheduled]" data-bootstrap-switch="" data-off-color="danger" data-on-color="success" value="on" 
                    {{!empty($data->notification_settings) ? (array_key_exists('request_scheduled',$data->notification_settings))? "checked" :"" :"checked"  }}>
                  </div>
                </div>
                <div class="form-group mb-2 row">
                  <div class="col-md-6">
                    <label for="notification_settings">{{ __('Request Underreview') }}</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" name="notification_settings[request_underreview]" data-bootstrap-switch="" data-off-color="danger" data-on-color="success" value="on"
                    {{!empty($data->notification_settings) ? (array_key_exists('request_underreview',$data->notification_settings))? "checked" :"" :"checked"  }}>
                  </div>
                </div>
                <div class="form-group mb-2 row">
                  <div class="col-md-6">
                    <label for="notification_settings">{{ __('Request Completed') }}</label>
                  </div>
                  <div class="col-md-6">
                    <input type="checkbox" name="notification_settings[request_completed]"  data-bootstrap-switch="" data-off-color="danger" data-on-color="success" value="on"
                    {{!empty($data->notification_settings) ? (array_key_exists('request_completed',$data->notification_settings))? "checked" :"" :"checked"  }}>
                  </div>
                </div>
                <div class="form-group row mt-3">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Update</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="notifications">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="subject" placeholder="Subject">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="message" class="col-sm-2 col-form-label">Message</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="message" placeholder="Message"></textarea>
                  </div>
                </div>
                <div class="row">
                  <label for="file" class="col-sm-2 col-form-label">File</label>
                  <div class="col-sm-10">
                    <input type="file" id="file">
                  </div>
                </div>
                <div class="form-group row mt-3">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection
@push('footer_extras')
<script>
   $(function() {
            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'))
            });
        })
</script>
@endpush