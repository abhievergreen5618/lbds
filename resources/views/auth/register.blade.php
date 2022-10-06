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
                                <form method="POST" action="{{ route('login') }}" class="row g-4  main-form">
                                @csrf
                                    <div class="col-12">
                                        <label for="email">{{ __('Company Name') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Company Address') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Zip Code') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Company Phone Number') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Name') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Direct Number') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Email Address') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="email">{{ __('Password') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <small>Password must have at least 6 characters.</small>
                                        </div>
                                        @error('email')
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



