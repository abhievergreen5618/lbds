@php
use Illuminate\Support\Facades\Storage;
@endphp
@push('header_extras')
<link rel="stylesheet" href="{{asset('/css/all.css')}}">
<style>
    /* The Modal (background) */
    .modal {
        display: none;
        position: fixed;
        left: 0%;
        top: 0%;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 1055;
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 100%;
        max-width: 900px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

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

    .custom-control.image-checkbox {
        position: relative;
        padding-left: 0;
    }

    .custom-control.image-checkbox .custom-control-input:checked~.custom-control-label:after,
    .custom-control.image-checkbox .custom-control-input:checked~.custom-control-label:before {
        opacity: 1;
    }

    .custom-control.image-checkbox label {
        cursor: pointer;
    }

    .custom-control.image-checkbox label:before {
        border-color: #007bff;
        background-color: #007bff;
    }

    .custom-control.image-checkbox label:after,
    .custom-control.image-checkbox label:before {
        transition: opacity .3s ease;
        opacity: 0;
        left: .25rem;
    }

    .custom-control.image-checkbox label:focus,
    .custom-control.image-checkbox label:hover {
        opacity: .8;
    }

    .custom-control.image-checkbox label img {
        border-radius: 2.5px;
    }

    .form-group-image-checkbox.is-invalid label {
        color: #dc3545;
    }

    .form-group-image-checkbox.is-invalid .invalid-feedback {
        display: block;
    }

    .note-editor {
        margin-left: 0px;
        margin-right: 0px;
    }


    input.valid.success-alert {
        background-image: none !important;
    }

    .overlay {
        position: absolute;
        bottom: 0;
        background: rgb(0, 0, 0) !important;
        background: rgba(0, 0, 0, 0.5);
        /* Black see-through */
        color: #f1f1f1;
        width: 100%;
        transition: .5s ease;
        opacity: 0;
        color: white;
        font-size: 20px;
        padding: 20px;
        text-align: center;
    }

    /* When you mouse over the container, fade in the overlay title */
    .custom-control-label:hover .overlay {
        opacity: 1;
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
                    <h6 class="mb-0 font-95 col-6 px-2 p-1 bg-dark font-weight-600"><span class="text-white">Request #{{$requestdetails->unique_request_id}}</span></h6>
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    <div class="status-label float-end">

                    </div>

                    <h4 class="mb-1 font-weight-bold text-right {{($requestdetails->status == 'completed') ? 'text-success' : 'text-danger' }}">{{($requestdetails->status == "underreview") ? "Under Review" : ucfirst($requestdetails->status)}} @if($requestdetails->status == 'completed') <i class='fas fa-check-double fa-sm'></i> @endif</h4>
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
                @php
                            $roles = $cancelbyuser->getRoleNames();
                            $role = $roles->first();
                @endphp
                Reason : {{$requestdetails->cancel_reason}} <br>
                Cancelled By : {{($role == "admin") ? $cancelbyuser->name : $cancelbyuser->company_name}} 
                <span class="text-dark">{{(Auth::user()->hasRole('admin')) ? "[".ucfirst($role)."]" : ""}}</span>
                <p class="mb-0 font-weight-500 mt-1 font-95 text-dark"></p>
            </div>
        </div>
        @endif
        <div class="col-md-12 mb-3 nav justify-content-between timeline">
            <div class="text-center single-timeline"> <i class="fas fa-check-circle text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Submitted</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->custom_created_at) ? date('F d ,Y',strtotime($requestdetails->custom_created_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline"><i class="{{!empty($requestdetails->assigned_at)  ? 'fas fa-check-circle' : 'far fa-clock'}}  text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Assigned</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->assigned_at) ? date('F d ,Y',strtotime($requestdetails->assigned_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline ">
                <i class="{{!empty($requestdetails->scheduled_at) ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Scheduled</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->scheduled_at) ? date('F d ,Y h:i a',strtotime($requestdetails->scheduled_at.$requestdetails->schedule_time)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="{{!empty($requestdetails->underreview_at) ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Under Review</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->underreview_at) ? date('F d ,Y',strtotime($requestdetails->underreview_at)) : "----
                    ---- ------ "}}</h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="{{!empty($requestdetails->completed_at) ? 'fas fa-check-circle' : 'far fa-clock'}} text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Completed</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95">{{!empty($requestdetails->completed_at) ? date('F d ,Y',strtotime($requestdetails->completed_at)) : "----
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
                            @if((Auth::user()->hasRole('admin') || Auth::user()->hasRole('company')) || Auth::user()->hasRole('employee')) 
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
                                    <td><input type="text" class="form-control" id="state" name="state" placeholder="State" value="{{old('state',$requestdetails->state)}}">
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
                                @if(Auth::user()->hasRole('admin'))
                                <tr>
                                    <td>Admin Notes:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Admin Notes" name="requestnote" id="requestnote">{{old('requestnote',$requestdetails->requestnote)}}</textarea></td>
                                </tr>
                                @endif
                                @endif
                                <!--inspector -->
                                @role('inspector')
                                <tr>
                                    <td>Applicant Name</td>
                                    <td><input type="text" class="form-control" id="applicantname" name="applicantname" placeholder="Name" value="{{old('applicantname',$requestdetails->applicantname)}}" class="form-control" readonly>
                                        @error('applicantname')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Email</td>
                                    <td><input type="email" class="form-control" id="applicantemail" name="applicantemail" placeholder="Email" value="{{old('applicantemail',$requestdetails->applicantemail)}}" readonly>
                                        @error('applicantemail')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Phone</td>
                                    <td><input type="number" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="Phone" value="{{old('applicantmobile',$requestdetails->applicantmobile)}}" readonly>
                                        @error('applicantmobile')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Address" id="address" name="address" readonly>{{old('address',$requestdetails->address)}}</textarea>
                                        @error('address')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{old('city',$requestdetails->city)}}" readonly>
                                        @error('city')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><input type="text" class="form-control" id="state" name="state" placeholder="State" value="{{old('state',$requestdetails->state)}}" readonly>
                                        @error('state')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td><input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="Zip Code" value="{{old('zipcode',$requestdetails->zipcode)}}" readonly>
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
                                                <input type="checkbox" value="{{$key}}" name="sendinvoice[]" @if(in_array($key,$requestdetails['sendinvoice'])) {{"checked"}} @endif onclick="return false" readonly >
                                                {{$value}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
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
                                                        <input id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}" @if(in_array($key,$requestdetails['inspectiontype'])) {{"checked"}} @endif onclick="return false" readonly>
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
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Comments" name="comments" id="comments" readonly>{{old('comments',$requestdetails->comments)}}</textarea></td>
                                </tr>
                                @endrole

                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('inspector'))
                                <tr>
                                    <td>Inspector Comment:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Inspector Comment" name="inspectorcomments" id="inspectorcomments">{{old('inspectorcomments',$requestdetails->inspectorcomments)}}</textarea></td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                            @if(!Auth::user()->hasRole('inspector'))
                                <tr>
                                    <td colspan="10">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                        <!-- <input id="btn-delete" type="button" class="btn btn-danger" value="Delete">
                                        <input id="btn-cancel" type="button" class="btn btn-danger" value="Cancel"> -->
                                    </td>
                                </tr>
                            @endif
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
                    @role('admin')
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
                            $link = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=Inspection&details=&location=&dates=".date("Ymd\THis\Z",strtotime($requestdetails->scheduled_at.$requestdetails->time))."/".date("Ymd\THis\Z",strtotime($requestdetails->scheduled_at.$requestdetails->time))."ctz=(GMT+5:30)";
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
                    @endrole
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div id="accordion">
            @if(!Auth::user()->hasRole('inspector'))
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
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('inspector'))
                                <div class="col-md-12 my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="reportfiles">{{ __('Reports Related Files') }}</label>
                                        <button class="btn bg-gradient-primary my-2 uploadfiles" data-id="{{encrypt($requestdetails->id)}}">Upload</button>
                                    </div>
                                    <div class="dropzone" id="reportfiles"></div>
                                </div>
                                @endif
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
                                        <div class="d-flex">
                                            <a href="{{route('filedownload',['filename' => $item])}}" data-file="{{ $item }}"><i class="fa fa-download" style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Download</i></a>
                                            <a href="" class="myImg ml-2" data-file="{{asset('taskfiles').'/'.$item}}"><i class="fa fa-eye"  style="font-size:15px !important; padding:6px !important; " aria-hidden="true">Preview</i></a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                @php
                                    if($ext == 'pdf')
                                    {
                                        $thumbimage =asset('images/defaultpdf.png');
                                    }
                                    else if($ext == 'docx')
                                    {
                                        $thumbimage =asset('images/defaultdocx.png');
                                    }
                                    else
                                    {
                                        $thumbimage =asset('images/defaultdocument.jpg');
                                    }
                                @endphp
                                <div class="col-lg-2 pdfview @if ($i >= 4) {{ 'mt-3' }} @endif " style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <div class="preview-images taskpdf h-100" data-file="{{ asset('taskfiles/' . $item) }}" style="background-image:linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 60%, rgba(0, 0, 0, 100.65) 100%),url({{$thumbimage}}); background-repeat: no-repeat; background-size: contain; background-position: center;">
                                        <span class="h-100 w-100 d-flex justify-content-end align-items-center flex-column text-light" style=" overflow: hidden;
                                                                                                        text-overflow: ellipsis; word-break: break-all;">
                                            {{ $item }}
                                        </span>
                                    </div>
                                    <a id="" href="#" data-file="{{ $item }}" class="remove-btn">Remove file
                                    </a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <div class="d-flex">
                                            <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download"  style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Download</i></a>
                                            <a class="ml-2" href="{{asset('taskfiles').'/'.$item}}" target="blank" data-file="{{ $item }}"><i class="fa fa-eye"  style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Preview</i></a>
                                        </div>
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
                @endif
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
                               @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('company') || Auth::user()->hasRole('employee'))
                                <div class="col-md-12 my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="relatedfiles">{{ __('Agency Related Files') }}</label>
                                        <button class="btn bg-gradient-primary my-2 uploadfiles" data-id="{{encrypt($requestdetails->id)}}">Upload</button>
                                    </div>
                                    <div class="dropzone" id="agencyfiles"></div>
                                </div>
                                @endif
                                @if(!empty($agencyfiles) && count($agencyfiles) != 0)
                                @php $i = 1; @endphp
                                @foreach ($agencyfiles as $key => $item)
                                @php
                                $info = pathinfo(public_path('taskfiles') . $item);
                                $ext = $info['extension'];
                                @endphp

                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                                <div class="col-lg-4 preview  @if ($i >= 6) {{ 'mt-3' }} @endif" style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <img src="{{ asset('taskfiles/' . $item) }}" class="img-thumbnail h-100 preview-images" alt="...">
                                    <a id="" href="#" data-file="{{ $item }}" class="remove-btn">Remove file</a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <div class="d-flex">
                                            <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download"  style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Download</i></a>
                                            <a href="#" class="myImg ml-2" data-file="{{asset('taskfiles').'/'.$item}}"><i class="fa fa-eye"  style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Preview</i></a>
                                        </div>
                                    </div>
                                </div>
                                @else
                                @php
                                    if($ext == 'pdf')
                                    {
                                        $thumbimage =asset('images/defaultpdf.png');
                                    }
                                    else if($ext == 'docx')
                                    {
                                        $thumbimage =asset('images/defaultdocx.png');
                                    }
                                    else
                                    {
                                        $thumbimage =asset('images/defaultdocument.jpg');
                                    }
                                @endphp
                                <div class="col-lg-2 pdfview @if ($i >= 6) {{ 'mt-3' }} @endif" style="cursor: pointer;" data-file="{{ asset('taskfiles/' . $item) }}">
                                    <div class="preview-images taskpdf h-100" data-file="{{ asset('taskfiles/' . $item) }}"  style="background-image:linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 60%, rgba(0, 0, 0, 100.65) 100%),url({{$thumbimage}}); background-repeat: no-repeat; background-size: contain; background-position: center;">
                                        <span class="h-100 w-100 d-flex justify-content-end align-items-center flex-column text-light" style=" overflow: hidden;
                                                                                                        text-overflow: ellipsis; word-break: break-all;">
                                            {{ $item }}
                                        </span>
                                    </div>
                                    <a id="" href="#" class="remove-btn">Remove file
                                    </a>
                                    <div class="image-overlay  position-absolute" style="display:none;">
                                        <div class="d-flex">
                                            <a href="{{route('filedownload',['filename' => $item])}}"><i class="fa fa-download" style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Download</i></a>
                                            <a class="ml-2" href="{{asset('taskfiles').'/'.$item}}" target="blank" data-file="{{ $item }}"><i class="fa fa-eye" style="font-size:15px !important; padding:6px !important;" aria-hidden="true">Preview</i></a>
                                        </div>
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
                @role('admin')
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-outline">
                                        <form action="{{route('sendmailreport')}}" id="reportmailform" method="post">
                                            <input type="hidden" name="requestid" value="{{encrypt($requestdetails['id'])}}">
                                            @csrf
                                            <div class="card-header">
                                                <h3 class="card-title">Compose New Message</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <div class="select2-purple my-2">
                                                        <select class="form-control" name="reportmailto[]" id="reportmailto" multiple>
                                                            @if(!empty($maillist) && count($maillist) != 0)
                                                            @foreach($maillist as $key=>$value)
                                                            <option value="{{$value}}" {{(!empty($maildraft['mailto']) && count($maildraft['mailto']) != 0) ? (in_array($value,$maildraft['mailto'])) ? 'selected' : '' : ''}}>{{__($value)}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('reportmailto')
                                                        <div>
                                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                                        </div>
                                                        @enderror
                                                        <!-- <input class="form-control" placeholder="To:"> -->
                                                    </div>
                                                    <div class="select2-purple  my-2">
                                                        <select class="form-control" name="reportmailcc[]" id="reportmailcc" multiple>
                                                            @if(!empty($maillist) && count($maillist) != 0)
                                                            @foreach($maillist as $key=>$value)
                                                            <option value="{{$value}}" {{(!empty($maildraft['mailcc']) && count($maildraft['mailcc']) != 0) ? (in_array($value,$maildraft['mailcc'])) ? 'selected' : '' : ''}}>{{__($value)}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('reportmailto')
                                                        <div>
                                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                                        </div>
                                                        @enderror
                                                        <!-- <input class="form-control" placeholder="To:"> -->
                                                    </div>
                                                    <div class="select2-purple  my-2">
                                                        <select class="form-control" name="reportmailbcc[]" id="reportmailbcc" multiple>
                                                            @if(!empty($maillist) && count($maillist) != 0)
                                                            @foreach($maillist as $key=>$value)
                                                            <option value="{{$value}}" {{(!empty($maildraft['mailbcc']) && count($maildraft['mailbcc']) != 0) ? (in_array($value,$maildraft['mailbcc'])) ? 'selected' : '' : ''}}>{{__($value)}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @error('reportmailto')
                                                        <div>
                                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                                        </div>
                                                        @enderror
                                                        <!-- <input class="form-control" placeholder="To:"> -->
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="form-control" placeholder="Subject:" name="subject" value="{{ @old('subject',$maildraft['subject']) }}">
                                                    @error('subject')
                                                    <div>
                                                        <label class="error fail-alert  mt-1">{{$message}}<label>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="compose-textarea" class="form-control summernote" style="height: 700px" name="message">{{ @old('message',$maildraft['message']) }}</textarea>
                                                    @error('message')
                                                    <div>
                                                        <label class="error fail-alert  mt-1">{{$message}}<label>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="card card-primary card-outline m-0">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Select Attachments</h3>
                                                            <div class="card-tools">
                                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="row">
                                                                @if(!empty($attachments) && count($attachments) != 0)
                                                                @php $i = 1; @endphp
                                                                @foreach ($attachments as $key => $item)
                                                                @php
                                                                $info = pathinfo(public_path('taskfiles') . $item);
                                                                $ext = $info['extension'];
                                                                $fileSize =Storage::disk('taskfiles')->size($item);
                                                                $exactfilesize = $mailhelper->formatBytes( $fileSize );
                                                                $fileSize = intval(abs(number_format($fileSize / 1048576,2)));
                                                                @endphp
                                                                @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                                                                <div class="col-md-3 @if ($i >= 5) {{ 'mt-3' }} @endif">
                                                                    <div class="custom-control custom-checkbox image-checkbox h-100">
                                                                        <input type="checkbox" class="custom-control-input checkattachments" data-file="{{ asset('taskfiles/' . $item) }}" name="attachments[]" data-size='{{$fileSize}}' value="{{ ($fileSize < 32 ? $item  : '')}}" id="ck_.{{$key}}" {{(!empty($maildraft['attachments']) && count($maildraft['attachments']) != 0) ? (in_array($item,$maildraft['attachments'])) ? 'checked' : '' : ($fileSize < 32 ? 'checked' : '')}}>
                                                                        <label class="custom-control-label h-100" for="ck_.{{$key}}">
                                                                            <img src="{{ asset('taskfiles/' . $item) }}" alt="#" class="img-fluid h-100">
                                                                            <div class="overlay">{{$exactfilesize}}</div>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                @else
                                                                <div class="col-md-3 @if ($i >= 5) {{ 'mt-3' }} @endif ">
                                                                    <div class="custom-control custom-checkbox image-checkbox h-100" style="min-height: 120px;">
                                                                        <input type="checkbox" class="custom-control-input checkattachments" data-file="{{ asset('taskfiles/' . $item) }}" name="attachments[]" data-size='{{$fileSize}}' value="{{ ($fileSize < 32 ? $item  : '') }}" id="ck_.{{$key}}" {{(!empty($maildraft['attachments']) && count($maildraft['attachments']) != 0) ? (in_array($item,$maildraft['attachments'])) ? 'checked' : '' : ($fileSize < 32 ? 'checked' : '')}}>
                                                                        <label class="custom-control-label h-100 w-100" for="ck_.{{$key}}">
                                                                            <div class="taskpdf h-100">
                                                                                <span class="h-100 w-100 d-flex justify-content-center align-items-center flex-column" style=" overflow: hidden;
                                                                                                        text-overflow: ellipsis; word-break: break-all;">
                                                                                    {{ $item }}
                                                                                </span>
                                                                                <div class="overlay">{{$exactfilesize}}</div>
                                                                            </div>
                                                                    </div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            @php
                                                            $i++;
                                                            @endphp
                                                            @endforeach
                                                            @else
                                                            <div class="col-md-12 my-2">
                                                                <p>No Attachments Founded</p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <!-- <div class="btn btn-default btn-file">
                                                    <i class="fas fa-paperclip"></i> Attachment
                                                    <input type="file" name="attachment">
                                                </div> -->
                                                        <!-- <p class="help-block">Max. 32MB</p> -->
                                                        @error('attachments')
                                                        <div>
                                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="float-right">
                                            <button type="submit" class="btn btn-default" name="btn" formnovalidate="formnovalidate" value="draft"><i class="fas fa-pencil-alt"></i>Draft</button>
                                            <button type="submit" class="btn btn-primary" name="btn" value="send"><i class="far fa-envelope"></i>Send</button>
                                        </div>
                                        <!-- <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button> -->
                                    </div>
                                    </form>
                                    <!-- /.card-footer -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>
    </div>
</div>
</div>

<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <div class="modal-dialog modal-dialog-centered">
        <img class="modal-content" id="img01">
    </div>
</div>

@endsection

@push('footer_extras')
<script>
    $(document).ready(function() {
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById("img01");
        $(document).on('click', '.myImg', function(event) {
            event.preventDefault();
            modal.style.display = "block";
            modalImg.src = $(this).attr('data-file');
        });
        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            modal.style.display = "none";
        }

        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
        $("#reportmailto").select2({
            tags: true,
            multiple: true,
            placeholder: "TO",
            createTag: function(term, data) {
                var value = term.term;
                if (validateEmail(value)) {
                    return {
                        id: value,
                        text: value
                    };
                }
                return null;
            }
        });
        $("#reportmailcc").select2({
            tags: true,
            multiple: true,
            placeholder: "CC",
            createTag: function(term, data) {
                var value = term.term;
                if (validateEmail(value)) {
                    return {
                        id: value,
                        text: value
                    };
                }
                return null;
            }
        });
        $("#reportmailbcc").select2({
            tags: true,
            multiple: true,
            placeholder: "BCC",
            createTag: function(term, data) {
                var value = term.term;
                if (validateEmail(value)) {
                    return {
                        id: value,
                        text: value
                    };
                }
                return null;
            }
        });
        $('#compose-textarea').summernote();
        let els = document.querySelectorAll('.source-code')

        for (let el of els) {
            let text = el.innerHTML

            // let fix the source code
            let lines = text.split("\n");
            let rows = [];
            let tabSize = 1000;

            for (let i = 0; i < lines.length; i++) {
                let line = lines[i];


                // - remove empty first and last line.
                if (!i || i == (lines.length - 1)) {
                    if (!line.trim())
                        continue;
                }

                // - find the correct tab size
                line = line.replace(/ +$/, '');
                if (line) {
                    let prefSpace = line.length - (line.trim()).length;
                    if (prefSpace < tabSize)
                        tabSize = prefSpace;
                }

                rows.push(line);
            }

            // - trim all rows by the shortest tab size
            for (let i = 0; i < rows.length; i++)
                rows[i] = rows[i].substr(tabSize)

            text = rows.join("\n");

            let parent = el.parentNode;
            let pre = document.createElement('pre');
            let code = document.createElement('code');
            code.classList.add('language-' + el.dataset.hl);
            pre.appendChild(code);
            parent.appendChild(pre);

            text = text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
            code.innerHTML = text;

            Prism.highlightElement(code);
        }
        $('.checkattachments').change(function() {
            if (this.checked) {
                var size = $(this).attr("data-size");
                var link = $(this).attr("data-file");
                if (size > 32) {
                    Swal.fire({
                        title: 'Are you sure?',
                        html: "<h6>File size is greater than 32mb you need to attach file <br> link as below in message.</h6><br><div class='row'><div class='col-md-12 text-center'><button id='copy' class='btn btn-primary' data-clipboard-text='" + link + "'>Copy to clipboard<i class='my-2 fas fa-copy'></i></button></div><div class='col-md-12'><b><a href='" + link + "' target='_blank'>" + link + "</a></b></div></div>",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).prop('checked', false);
                        } else {
                            $(this).prop('checked', false);
                        }
                    })
                }
            }
        });
    });
</script>
@endpush
