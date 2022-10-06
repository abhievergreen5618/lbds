@push('header_extras')
<style>
    a {
        text-decoration: none;
    }

    .login-page {
        width: 100%;
        height: 100vh;
        display: inline-block;
        display: flex;
        align-items: center;
    }

    .form-right i {
        font-size: 100px;
    }
    .main-form
    {
        height: 400px;
    }
</style>
@endpush
@extends('layouts.auth')

@section('content')
<div class="login-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h3 class="mb-3">{{ __('Register Now') }}</h3>
                <div class="bg-white shadow rounded">
                    <div class="row">
                        <div class="col-md-6 pe-0">
                            <div class="form-left h-100 py-5 px-5 overflow-auto">
                                <form method="POST" action="{{ route('agency-insert') }}" class="row g-4  main-form">
                                @csrf
                                    <div class="col-12">
                                        <label for="company_name">{{ __('Company Name') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-city"></i></div>
                                            <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>
                                        </div>
                                        @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="company_address">{{ __('Company Address') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-address-card"></i></div>
                                            <input id="company_address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" required autocomplete="company_address" autofocus>
                                        </div>
                                        @error('company_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="city">{{ __('City') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-building"></i></div>
                                            <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                        </div>
                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="zip_code">{{ __('Zip Code') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-duotone fa-city"></i></div>
                                            <input id="zip_code" type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ old('zip_code') }}" required autocomplete="zip_code" autofocus>
                                        </div>
                                        @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="company_phonenumber">{{ __('Company Phone Number') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-phone-alt"></i></div>
                                            <input id="company_phonenumber" type="text" class="form-control @error('company_phonenumber') is-invalid @enderror" name="company_phonenumber" value="{{ old('company_phonenumber') }}" required autocomplete="company_phonenumber" autofocus>
                                        </div>
                                        @error('company_phonenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <p class="border-bottom mt-5"></p>
                                    <div class="col-12">
                                        <label for="name">{{ __('Name') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        </div>
                                        @error('name')
                                        <span class="invalid-feedback" roleHomeController="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="direct_number">{{ __('Direct Number') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-phone-volume"></i></div>
                                            <input id="direct_number" type="text" class="form-control @error('direct_number') is-invalid @enderror" name="direct_number" value="{{ old('direct_number') }}" required autocomplete="direct_number" autofocus>
                                        </div>
                                        @error('direct_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Email Address') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-envelope"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-solid fa-key"></i></div>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                                        </div>
                                        <small><i class="fa fa-info-circle"></i>Password must have at least 6 characters.</small>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <!-- <div class="col-lg-12 text-center">
                                        <a href="{{ route('register') }}" class="text-center text-primary">Register a new membership</a>
                                    </div> -->
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary px-4 text-center mt-4">{{ __('Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 ps-0 d-none d-md-block">
                            <div class="form-right h-100 bg-danger text-white text-center pt-5">
                                <i class="bi bi-bootstrap"></i>
                                <h2 class="fs-1">Welcome Back!!!</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



