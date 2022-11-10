@push('header_extras')
<link rel="stylesheet" href="{{asset('/css/all.css')}}">
<style>
    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: flex;
        justify-content: space-around;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 20px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    /* .btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
} */

    .btn-circle {
        width: 44px;
        height: 40px;
        text-align: center;
        padding: 10px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    .requestdetailcard {
        background-color: #007bff;
        color: white;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: black !important;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .section1 {
        background-color: #f5f5f5;
        padding: 2%;
    }

    h4.mb-1.font-weight-bold.text-danger {
        text-align: right;
    }

    .container-fluid.VV {
        background-color: white;
        padding: 28PX;
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
        margin-top: 15px;
    }

    svg.svg-inline--fa.fa-bars.fa-w-14.fa-lg {
        color: black;
        margin-top: 7px;
    }

    .px-4.nav.justify-content-between {
        margin-top: -19%;
    }

    button.accordion-button.collapsed {
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
        padding-top: 19px;
        margin-top: 23px;
        font-weight: 500;
        font-size: 20px;
    }

    .row.btn-danger {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
    }

    .col-12.p-4.bg-white.shadow-sm.brequest.rounded-10 {
        margin-top: 24px;
    }

    h6.mb-0.font-95.float-end.col-6.px-2.p-1.bg-dark.font-weight-600.text-white {
        float: right !important;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="section1">
    <div class="container-fluid">
        <div class="row jj">
            <div class="col-md-6">
                <div>
                    <h3 class="mb-1 font-weight-bold text-black">Request
                        Information</h3>
                    <h6 class="mb-0 font-95 col-6 px-2 p-1 bg-dark
                        font-weight-600"><span class="text-white">Request #{{$requestdetails->id}}</span></h6>
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    <div class="status-label float-end">

                    </div>

                    <h4 class="mb-1 font-weight-bold text-right {{($requestdetails->status == 'completed') ? 'text-success' : 'text-danger' }}">{{ucfirst($requestdetails->status)}} @if($requestdetails->status == 'completed') <i class='fas fa-check-double fa-sm'></i> @endif</h4>
                    <h6 class="mb-0 font-95 float-end col-6 px-2 p-1 bg-dark font-weight-600 text-white"><span class="font-weight-500">Assigned To:</span>{{!empty($requestdetails->assigned_ins) ? $inspectordetails->name : "" }} </h6>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid VV">
        @if($requestdetails->status == "cancelled")
        <div class="col-12">
            <div class="alert cancelrequest font-weight-600 mb-3 alert-light text-black p-3 rounded-10 h6 border" style="border-left:5px solid red !important;">
                <h5 class="text-danger font-weight-bold mb-0">{{ucfirst($requestdetails->status)}}</h5>
                <hr class="my-2">
                Reason : {{$requestdetails->cancel_reason}} <br>
                Cancelled By : Admin <span class="text-dark">[Admin]</span>
                <p class="mb-0 font-weight-500 mt-1 font-95 text-dark"></p>
            </div>
        </div>
        @endif
        <div class="col-md-12 mb-3 nav justify-content-between timeline">
            <div class="text-center single-timeline"> <i class="fas fa-check-circle text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Submitted</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->created_at) ? date('F d ,Y',strtotime($requestdetails->created_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline"><i class="{{($requestdetails->status == 'scheduled' || $requestdetails->status == 'underreview' || $requestdetails->status == 'completed' || $requestdetails->status == 'assigned') ? 'fas fa-check-circle' : 'far fa-clock'}}  text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Assigned</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->assigned_at) ? date('F d ,Y',strtotime($requestdetails->assigned_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline ">
                <i class="{{($requestdetails->status == 'scheduled' || $requestdetails->status == 'underreview' || $requestdetails->status == 'completed') ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Scheduled</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->scheduled_at) ? date('F d ,Y h:i a',strtotime($requestdetails->scheduled_at.$requestdetails->schedule_time)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="{{($requestdetails->status == 'underreview' || $requestdetails->status == 'completed') ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Under Review</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->underreview_at) ? date('F d ,Y',strtotime($requestdetails->underreview_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="{{($requestdetails->status == 'completed') ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Completed</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->completed_at) ? date('F d ,Y',strtotime($requestdetails->scheduled_at)) : "----
                    ---- ------ "}}</h6>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12 mb-3 nav ">
                <div class="col-md-6 mb-3">
                    <form id="requestform" method="post" action="{{route('requestupdate')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{encrypt($requestdetails->id)}}">
                        <table class="table table-responsive brequest">
                            <tbody>
                                <tr>
                                    <td>Applicant Name</td>
                                    <td><input type="text" class="form-control" id="applicantname" name="applicantname" placeholder="Name" value="{{old('applicantname',$requestdetails->applicantname)}}" class="form-control">
                                        @error('applicantname')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Email</td>
                                    <td><input type="email" class="form-control" id="applicantemail" name="applicantemail" placeholder="Email" value="{{old('applicantemail',$requestdetails->applicantemail)}}">
                                        @error('applicantemail')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Phone</td>
                                    <td><input type="number" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="Phone" value="{{old('applicantmobile',$requestdetails->applicantmobile)}}">
                                        @error('applicantmobile')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Address" id="address" name="address">{{old('address',$requestdetails->address)}}</textarea>
                                        @error('address')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{old('city',$requestdetails->city)}}">
                                        @error('city')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><input type="number" class="form-control" id="state" name="state" placeholder="State" value="{{old('state',$requestdetails->state)}}">
                                        @error('state')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td><input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="ZipCode" value="{{old('zipcode',$requestdetails->zipcode)}}">
                                        @error('zipcode')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                @if(!empty($invoicedata) && count($invoicedata) != 0)
                                <tr>
                                    <td>Send Invoice(s) To:</td>
                                    <td>
                                        @foreach($invoicedata as $key=>$value)
                                        <div>
                                            <label class="px-2 py-1 mb-1">
                                                <input type="checkbox" value="{{$key}}" name="sendinvoice[]" @if(in_array($key,$requestdetails['sendinvoice'])) {{"checked"}} @endif>
                                                {{$value}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                @role('admin')
                                <tr>
                                    <td>Inspection Fee</td>
                                    <td><input type="number" name="ins_fee" id="ins_fee" placeholder="Inspection Fee" value="{{old('ins_fee',$requestdetails->ins_fee)}}"></td>
                                </tr>
                                @endrole
                                @if(!empty($data) && count($data) != 0 && !empty($requestdetails['inspectiontype']))
                                <tr>
                                    <td>Inspection Type</td>
                                    <td>
                                        <div class="form-group">
                                            <label>Select Inspection Type:</label>
                                            <div class="row type">
                                                @foreach($data as $key=>$value)
                                                <div class="col-md-6">
                                                    <label class="px-2 py-1 border mb-2
                                                border col-md-12">
                                                        <input id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}" @if(in_array($key,$requestdetails['inspectiontype'])) {{"checked"}} @endif>
                                                        {{$value}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Comments:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Comments" name="comments" id="comments">{{old('comments',$requestdetails->comments)}}</textarea></td>
                                </tr>
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('company'))
                                <tr>
                                    <td>Agency Comment:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Agency Comment" name="agencycomments" id="agencycomments">{{old('agencycomments',$requestdetails->agencycomments)}}</textarea></td>
                                </tr>
                                @endif
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('inspector'))
                                <tr>
                                    <td>Inspector Comment:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Inspector Comment" name="inspectorcomments" id="inspectorcomments">{{old('inspectorcomments',$requestdetails->inspectorcomments)}}</textarea></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                        <!-- <input id="btn-delete" type="button" class="btn btn-danger" value="Delete">
                                        <input id="btn-cancel" type="button" class="btn btn-danger" value="Cancel"> -->
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
                <div class="col-md-6 mb-3">
                    <table class="table brequest">
                        <tbody>
                            <tr>
                                <td>Company Name</td>
                                <td>
                                    {{$companydetails->company_name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Company Address</td>
                                <td>
                                    {{$companydetails->company_address}}
                                </td>
                            </tr>
                            <tr>
                                <td>Company Phone</td>
                                <td>{{$companydetails->company_phonenumber}}</td>
                            </tr>
                            <tr>
                                <td>Agent Name</td>
                                <td>{{$companydetails->name}}</td>
                            </tr>
                            <tr>
                                <td>Agent Direct Number</td>
                                <td>{{$companydetails->direct_number}}</td>
                            </tr>
                            <tr>
                                <td>Agent Email</td>
                                <td>{{$companydetails->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($requestdetails->status != "underreview" && $requestdetails->status != "completed")
                    @if(!empty($requestdetails->assigned_at))
                    <div class="mt-3 mb-3 scheduled0eaff1"> <span class="btn
                            btn-danger col-12 shadow-sm font-weight-600 btn-sm
                            pointer"> Schedule Inspection &nbsp; <i class="fas
                                fa-arrow-down fa-sm"></i></span> <br>
                        <form method="post" action="{{route('requestschedule')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{encrypt($requestdetails->id)}}">
                            <div class="my-2">
                                <input type="date" class="border p-2 form-control" id="date" name="date" min="2022-10-21" value="{{old('date',$requestdetails->scheduled_at)}}">
                                @error('date')
                                <div>
                                    <label class="error fail-alert  mt-1">{{$message}}<label>
                                </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <input type="time" class="border p-2 form-control" id="time" name="time" value="{{old('time',$requestdetails->schedule_time)}}">
                                @error('time')
                                <div>
                                    <label class="error fail-alert  mt-1">{{$message}}<label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-12  text-center">
                                <button type="submit" class="btn btn-success font-weight-500 btn-reschedule border" id="0eaff1">Submit<i class="fas fa-savefa-sm"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="status-label mt-2">
                        <span id="btn-calendar" class="btn btn-sm btn-dark
                            font-weight-500 py-0 shadow pointer">
                            @if(!empty($requestdetails->scheduled_at))
                            @php
                            $link = "https://calendar.google.com/calendar/r/eventedit?text=Inspection&details=test&location=&dates=".$requestdetails->scheduled_at."T".$requestdetails->time."ctz=(GMT+5:30)";
                            @endphp
                            @else
                            @php
                            $link = "#";
                            @endphp
                            @endif
                            <a href="{{$link}}" class="text-light"><i class="fas
                                fa-calendar"></i> Add to Calendar </span> </a>
                        <span id="btn-calendar-google" class="btn btn-sm btn-info
                            font-weight-500 py-0 shadow pointer"> <i class="fas
                                fa-calendar"></i> Add to Google WorkSpace </span>
                    </div>
                    @else
                    <div class="mt-3 mb-3 scheduled0eaff1"> <span class="btn
                            btn-danger col-12 shadow-sm font-weight-600 btn-sm
                            pointer">Assign Inspector &nbsp; <i class="fas
                                fa-arrow-down fa-sm"></i></span> <br>
                        <form method="post" action="{{route('inspectorassign')}}">
                            @csrf
                            <input type="hidden" name="reqid" value="{{encrypt($requestdetails->id)}}">
                            <div class="my-2">
                                <select class="form-control" name="id" id="agency">
                                    <option value="">Select Inspector</option>
                                    @forelse($inslist as $key=>$value)
                                    <option value="{{encrypt($key)}}">{{__($value)}}</option>
                                    @empty
                                    <option value="">No Inspector Founded</option>
                                    @endforelse
                                </select>
                                @error('id')
                                <div>
                                    <label class="error fail-alert  mt-1">{{$message}}<label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-12  text-center">
                                <button type="submit" class="btn btn-success font-weight-500 btn-reschedule border" id="0eaff1">Submit<i class="fas fa-savefa-sm"></i></button>
                            </div>
                        </form>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div id="accordion">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                Completed Reports Uploads
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @role('admin')
                                <div class="col-md-12 my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="reportfiles">{{ __('Reports Related Files') }}</label>
                                        <button class="btn bg-gradient-primary my-2 uploadfiles" data-id="{{encrypt($requestdetails->id)}}">Upload</button>
                                    </div>
                                    <div class="dropzone" id="reportfiles"></div>
                                </div>
                                @endrole
                                @if(!empty($reportfiles) && count($reportfiles) != 0)
                                @php $i = 1; @endphp
                                @foreach ($reportfiles as $key => $item)
                                @php
                                $info = pathinfo(public_path('taskfiles') . $item);
                                $ext = $info['extension'];
                                @endphp

                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                                <div class="col-lg-4 preview  @if ($i >= 4) {{ 'mt-3' }} @endif" style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <img src="{{ asset('taskfiles/' . $item) }}" class="img-thumbnail h-100 preview-images" alt="...">
                                    <a id="" href="#" data-file="{{ $item }}" class="remove-btn">Remove file</a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <a href="{{route('filedownload',['filename' => $item])}}" data-file="{{ $item }}"><i class="fa fa-download" aria-hidden="true"></i></a>
                                        <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-4 pdfview @if ($i >= 4) {{ 'mt-3' }} @endif " style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <div class="preview-images taskpdf h-100" data-file="{{ asset('taskfiles/' . $item) }}">
                                        <span class="h-100 w-100 d-flex justify-content-center align-items-center flex-column" style=" overflow: hidden;
                                                                                                        text-overflow: ellipsis; word-break: break-all;">
                                            {{ $item }}
                                        </span>
                                    </div>
                                    <a id="" href="#" data-file="{{ $item }}" class="remove-btn">Remove file
                                    </a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download" aria-hidden="true"></i></a>
                                        <a href="{{asset('taskfiles').'/'.$item}}" target="blank" data-file="{{ $item }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @endif
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @else
                                <div class="col-md-12 my-2">
                                    <p>No Files Founded</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-danger">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                                Agency Uploads
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                @role('admin')
                                <div class="col-md-12 my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="relatedfiles">{{ __('Agency Related Files') }}</label>
                                        <button class="btn bg-gradient-primary my-2 uploadfiles" data-id="{{encrypt($requestdetails->id)}}">Upload</button>
                                    </div>
                                    <div class="dropzone" id="agencyfiles"></div>
                                </div>
                                @endrole
                                @if(!empty($agencyfiles) && count($agencyfiles) != 0)
                                @php $i = 1; @endphp
                                @foreach ($agencyfiles as $key => $item)
                                @php
                                $info = pathinfo(public_path('taskfiles') . $item);
                                $ext = $info['extension'];
                                @endphp

                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                                <div class="col-lg-4 preview  @if ($i >= 4) {{ 'mt-3' }} @endif" style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <img src="{{ asset('taskfiles/' . $item) }}" class="img-thumbnail h-100 preview-images" alt="...">
                                    <a id="" href="#" data-file="{{ $item }}" class="remove-btn">Remove file</a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download" aria-hidden="true"></i></a>
                                        <a href="" data-file="{{ $item }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @else
                                <div class="col-lg-4 pdfview @if ($i >= 4) {{ 'mt-3' }} @endif" style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <div class="preview-images taskpdf h-100" data-file="{{ asset('taskfiles/' . $item) }}">
                                        <span class="h-100 w-100 d-flex justify-content-center align-items-center flex-column" style=" overflow: hidden;
                                                                                                        text-overflow: ellipsis; word-break: break-all;">
                                            {{ $item }}
                                        </span>
                                    </div>
                                    <a id="" href="#" class="remove-btn">Remove file
                                    </a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download" aria-hidden="true"></i></a>
                                        <a href="{{asset('taskfiles').'/'.$item}}" target="blank" data-file="{{ $item }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                @endif
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @else
                                <div class="col-md-12 my-2">
                                    <p>No Files Founded</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-success">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false">
                                Send report
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                            3
                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum
                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                            nulla
                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                            beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                            labore sustainable VHS.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection