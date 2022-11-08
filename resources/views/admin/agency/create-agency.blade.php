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
                <h3 class="card-title">{{ __('Add New Agency') }}</h3>
            </div>
                <form id="{{ (isset($data)) ? 'agencyupdateform' : 'agencyaddform' }}" method="post" action="@if(isset($data)) {{route('admin.agency.update-agency')}} 
                @else{{ route('admin.agency.agency-insert') }} @endif" class="agency-register-form" id="agency-register-form">
                    @csrf
                    @isset($data)
                    <input type="hidden" name="id" value="{{encrypt($data->id)}}">
                    @endisset
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="company_name">{{ __('Company Name') }}:</label>

                                <input id="company_name" type="text"
                                    class="form-control @error('company_name') {{ 'is-invalid' }} @enderror" name="company_name"
                                    value="{{@old('company_name',$data->company_name)}}">
                                @error('company_name')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="city">{{ __('City') }} :</label>

                                <input id="city" type="text"
                                    class="form-control @error('city') {{ 'is-invalid' }} @enderror" name="city"
                                    value="{{@old('city',$data->city)}}">
                                @error('city')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="company_address">{{ __('Company Address') }} :</label>
                                <input id="company_address" type="text"
                                    class="form-control @error('company_address') {{ 'is-invalid' }} @enderror"
                                    name="company_address" value="{{@old('company_address',$data->company_address)}}">
                                @error('company_address')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company_phonenumber">{{ __('Company Phone Number') }}<span
                                        class="text-danger">*</span></label>
                                <input id="company_phonenumber" type="number"
                                    class="form-control @error('company_phonenumber') {{ 'is-invalid' }} @enderror"
                                    name="company_phonenumber" value="{{@old('company_phonenumber',$data->company_phonenumber)}}">
                                @error('company_phonenumber')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <div class="col-md-6 form-group">
                                <label for="name">{{ __('Name') }} :</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') {{ 'is-invalid' }} @enderror" name="name"
                                    value="{{@old('name',$data->name)}}">

                                @error('name')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="direct_number">{{ __('Direct Number') }}</label>
                                <input id="direct_number" type="number"
                                    class="form-control @error('direct_number') {{ 'is-invalid' }} @enderror" name="direct_number"
                                    value="{{@old('direct_number',$data->direct_number)}}">
                                @error('direct_number')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="zip_code" class="form-label">{{ __('Zip Code') }}</label>
                                <input id="zip_code" type="number"
                                    class="form-control @error('zip_code') {{ 'is-invalid' }} @enderror" name="zip_code"
                                    value="{{@old('zip_code',$data->zip_code)}}">
                                @error('zip_code')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>



                            <div class="col-md-6 form-group">
                                <label for="email">{{ __('Email Address') }} :</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') {{ 'is-invalid' }} @enderror" name="email"
                                    value="{{@old('email',$data->email)}}">

                                @error('email')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                            
                            @if(empty($data->id))
                            <div class="col-md-6 form-group">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') {{ 'is-invalid' }} @enderror" name="password">

                                <small>Password must have at least 8 characters.</small>
                                @error('password')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group">

                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" type="text"
                                    class="form-control @error('password_confirmation') {{ 'is-invalid' }} @enderror"
                                    name="password_confirmation" >

                                <small>Password must have at least 8 characters.</small>
                                @error('password_confirmation')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                        @else
                        <a href="{{ route('admin.agency.passwordReset',['id'=>encrypt($data->id)]) }}" class="btn btn-primary" id="reset-password">Reset Password</a>
                          
                           
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
