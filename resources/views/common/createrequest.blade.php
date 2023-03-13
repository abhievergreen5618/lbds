@push('header_extras')
<style>
    .others {
        margin-left: 10px !important;
    }
</style>
@endpush

@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
           <h3 class="card-title">{{ __('Add New Request') }}</h3>
        </div>
		  <div align="center" style="padding-top: 18px;"><span style="color: #FF0000;"><strong>*</strong></span> Indicates Required Field</div> 
        <!-- /.card-header -->
        <!-- form start -->
        <form id="requestform">
            <!-- {{$id}} -->
            @if(!empty($id))
            <input type='hidden' value='{{encrypt($id)}}' name='id'>
            @endif
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    @if(!Auth::user()->hasRole('company') && !Auth::user()->hasRole('employee'))
                    <div class="col-md-12 my-2">
                        <span style="color: #FF0000;"><strong>*</strong></span> <label for="report">{{ __('Agencies') }}</label>
                        <select class="form-control" name="agency" id="agency">
                            <option value="">Select Agency</option>
                            @if(!empty($companydetails) && count($companydetails) != 0)
                            @foreach($companydetails as $key=>$value)
                            <option value="{{encrypt($key)}}">{{__($value)}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @endif
                    @if(Auth::user()->hasRole('company'))
                    <input type="hidden" name="agency" value="{{encrypt(auth()->user()->id)}}">
                    @endif
                    @if(Auth::user()->hasRole('employee'))
                    <input type="hidden" name="agency" value="{{encrypt(auth()->user()->company_id)}}">
                    @endif
                    @if(!empty($data) && count($data) != 0)
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                            <span style="color: #FF0000;"><strong>*</strong></span> <label for="">{{ __('Select Inspection Type') }}</label>
                            </div>
                            @foreach($data as $key=>$value)
                            @php
                            $disableinspectionroles = $option->get_option("disableinspectionroles_".$key);
                            $disableinspectionusers = $option->get_option("disableinspectionusers_".$key);
                            $roledisable = false;
                            if(!empty($disableinspectionroles))
                            {
                            $roledisable = (in_array($roleid['id'], json_decode($disableinspectionroles, true))) ? true : false;
                            }
                            @endphp
                            @if($roledisable == false && !empty($disableinspectionusers))
                            @if(!in_array(Auth::user()->id, json_decode($disableinspectionusers, true)))
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}">
                                    <label class="form-check-label" for="inspection-type-{{$key}}">{{__($value)}}</label>
                                </div>
                            </div>
                            @else
                            @php
                            $roledisable == false;
                            @endphp
                            @endif
                            @elseif($roledisable == false)
                                <div class="col-lg-4 my-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}">
                                        <label class="form-check-label" for="inspection-type-{{$key}}">{{__($value)}}</label>
                                    </div>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                            <span style="color: #FF0000;"><strong>*</strong></span> <label for="">{{ __('Insured / Applicant Information') }}</label>
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="applicantname">{{ __('Name') }}</label>
                                <input type="text" class="form-control" id="applicantname" name="applicantname" placeholder="Name">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="applicantemail">{{ __('Email address') }}</label>
                                <input type="email" class="form-control" id="applicantemail" name="applicantemail" placeholder="Email">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="applicantmobile">{{ __('Phone') }}</label>
                                <input type="text" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="# Format: 123-456-7890">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                            <span style="color: #FF0000;"><strong>*</strong></span> <label for="">{{ __('Subject Property Information') }}</label>
                            </div>
                            <div class="col-lg-12 my-2">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea class="form-control" rows="3" placeholder="Enter Address" id="address" name="address"></textarea>
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="city">{{ __('City') }}</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="City">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="state">{{ __('State') }}</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="State">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="zipcode">{{ __('Zip Code') }}</label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip Code">
                            </div>
                        </div>
                    </div>
                    @if(!empty($invoicedata) && count($invoicedata) != 0)
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                            <span style="color: #FF0000;"><strong>*</strong></span> <label for="">{{ __('Send Invoice(s) To:') }}</label>
                            </div>
                            @foreach($invoicedata as $key=>$value)
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="send-invoice-{{$key}}" type="checkbox" name="sendinvoice[]" value="{{$key}}">
                                    <label class="form-check-label" for="send-invoice-{{$key}}">{{__($value)}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 my-2">
                        <label for="comments">{{ __('Comments') }}</label>
                        <textarea class="form-control" rows="3" placeholder="Enter Comments" name="comments" id="comments"></textarea>
                    </div>
                    @if(Auth::user()->hasRole('company') || Auth::user()->hasRole('employee'))
                    <div class="col-md-12 my-2">
                        <label for="relatedfiles">{{ __('Agency Related Files') }}</label>
                        <div class="dropzone" id="agencyfiles"></div>
                    </div>
                    @else
                    <div class="col-md-6 my-2">
                        <label for="relatedfiles">{{ __('Agency Related Files') }}</label>
                        <div class="dropzone" id="agencyfiles"></div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="relatedfiles">{{ __('Reports Related Files') }}</label>
                        <div class="dropzone" id="reportfiles"></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push("footer_extras")
<script>
window.onbeforeunload = function() {
   if (data_needs_saving()) {
       return "Do you really want to leave our brilliant application?";
   } else {
      return;
   }
};
</script>
@endpush