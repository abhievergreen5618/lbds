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
            <h3 class="card-title">{{ __('Add New Employee') }}</h3>
        </div>
        <form id="{{ (isset($data)) ? 'employeeupdateform' : 'employeeaddform' }}" action="@if(isset($data)) {{route('admin.employee.update')}} @else {{route('admin.employee.create')}} @endif" method="post">
            @csrf

            @isset($data)
            <input type="hidden" name="id" value="{{encrypt($data->id)}}">
            @endisset
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-4 my-2">
                                <label for="employeename">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('employeename') is-invalid @enderror" id="employeename" name="employeename" placeholder="Name" value="{{@old('name',$data->name)}}">
                                @error('employeename')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="employeeemail">{{ __('Email address') }}</label>
                                <input type="email" class="form-control @error('employeeemail') is-invalid @enderror" id="employeeemail" name="employeeemail" placeholder="Email"  value="{{@old('email',$data->email)}}">
                                @error('employeeemail')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="employeemobile">{{ __('Phone') }}</label>
                                <input type="number" class="form-control  @error('employeemobile') is-invalid @enderror" id="employeemobile" name="employeemobile" placeholder="Phone" value="{{@old('company_phonenumber',$data->company_phonenumber)}}">
                                @error('employeemobile')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12 my-2">
                                <label for="employeeaddress">{{ __('Address') }}</label>
                                <textarea class="form-control @error('employeeaddress') is-invalid @enderror" rows="3" placeholder="Enter Address" id="employeeaddress" name="employeeaddress">{{@old('company_address',$data->company_address)}}</textarea>
                                @error('employeeaddress')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="employeecity">{{ __('City') }}</label>
                                <input type="text" class="form-control @error('employeecity') is-invalid @enderror" id="employeecity" name="employeecity" placeholder="City" value="{{@old('city',$data->city)}}">
                                @error('employeecity')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="employeestate">{{ __('State') }}</label>
                                <input type="number" class="form-control @error('employeestate') is-invalid @enderror" id="employeestate" name="employeestate" placeholder="State" value="{{@old('state',$data->state)}}">
                                @error('employeestate')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="employeezipcode">{{ __('ZipCode') }}</label>
                                <input type="number" class="form-control @error('employeezipcode') is-invalid @enderror" id="employeezipcode" name="employeezipcode" placeholder="ZipCode" value="{{@old('zip_code',$data->zip_code)}}">
                                @error('employeezipcode')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                                <div>
                                    <small>Password must have at least 8 characters.</small>
                                </div>
                                @error('password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
                                @error('password_confirmation')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

