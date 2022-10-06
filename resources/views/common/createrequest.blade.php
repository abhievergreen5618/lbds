@push('header_extras')
<style>
    .others{
        margin-left: 10px !important;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Submit New Request') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="requestform">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Select Inspection Type') }}</label>
                            </div>
                            @foreach($data as $key=>$value)
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="inspectiontype" value="{{$key}}">
                                    <label class="form-check-label">{{__($value)}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Insured / Applicant Information') }}</label>
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
                                <input type="number" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="Phone">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Subject Property Information') }}</label>
                            </div>
                            <div class="col-lg-12 my-2">
                                <label for="address">{{ __('Address') }}</label>
                                <textarea class="form-control" rows="3" placeholder="Enter ..." id="address" name="address"></textarea>
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="city">{{ __('City') }}</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" id="city" name="city" placeholder="Password">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="zipcode">{{ __('State') }}</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" id="state" name="state" placeholder="Password">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="zipcode">{{ __('ZipCode') }}</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" id="zipcode" name="zipcode" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Send Invoice(s) To:') }}</label>
                            </div>
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">{{__('Checkbox')}}</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">{{__('Checkbox')}}</label>
                                </div>
                            </div>
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text align-items-center">
                                            <label class="form-check-label">{{__('Others')}}</label>
                                            <input class="form-check-input mt-0 others" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <label for="comments">{{ __('Comments') }}</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="comments" id="comments"></textarea>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="report">{{ __('Reports') }}</label>
                        <select class="form-control" name="report">
                            <option>Select Reports</option>
                            <option>Agency Uploads</option>
                        </select>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="relatedfiles">{{ __('Related Files') }}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="relatedfiles" name="relatedfiles">
                                <label class="custom-file-label" for="report">Choose file</label>
                            </div>
                        </div>
                        </select>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection