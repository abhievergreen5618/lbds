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
</style>
@endpush
@extends('layouts.auth')

@section('content')
<section class="vh-100 one1">
    <div class="container h-custom">
      <div class="row gt d-flex justify-content-center align-items-center h-100">
         <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                       <div class="logooo">
        <a class="navbar-brand" href="#">
        <img src="images/lg.png" alt="" class="d-inline-block align-text-top">
      
      </a>
      </div>
          <form class="formm" method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">{{ __('Or') }}</p>
            </div>
  
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter a valid email address" autocomplete="email" autofocus>
                <label class="form-label" for="email">{{ __('Email Address') }}</label>
                @error('email')
                <div>
                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                </div>
                @enderror
            </div>
  
            <!-- Password input -->
            <div class="form-outline mb-3">
                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                <label class="form-label" for="password">{{ __('Password') }}</label>
                @error('password')
                <div>
                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                </div>
                @enderror
            </div>
  
            <div class="d-flex justify-content-between align-items-center">
              <!-- Checkbox -->
              <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" id="inlineFormCheck">
                <label class="form-check-label" for="inlineFormCheck">
                    {{ __('Remember Me') }}
                </label>
              </div>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="text-body">{{ __('Forgot Your Password?') }}</a>
              @endif
            </div>
  
            <div class="text-center text-lg-start mt-2 pt-2">
              <button type="submit" class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ __('Login') }}</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                  class="link-danger">{{ __('Register') }}</a></p>
            </div>
  
          </form>
        </div>
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="images/hh.jpg"
            class="img-fluid" alt="Sample image">
        </div>
       
      </div>
    </div>
   
  </section>
  
  
{{-- <div class="login-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h3 class="mb-3">{{ __('Login') }}</h3>
                <div class="bg-white shadow rounded">
                    <div class="row">
                        <div class="col-md-7 pe-0">
                            <div class="form-left h-100 py-5 px-5">
                                <form method="POST" action="{{ route('login') }}" class="row g-4">
                                @csrf
                                    <div class="col-12">
                                        <label for="email">{{ __('Email Address') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-user"></i></div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password">{{ __('Password') }}<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa fa-key"></i></div>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                        </div>
                                        @error('password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                            <label class="form-check-label" for="inlineFormCheck">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        @if (Route::has('password.request'))
                                        <a class="float-end text-primary" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>
                                    <div class="col-lg-12">
                                        <a href="{{ route('register') }}" class="float-end text-primary">Register a new membership</a>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary px-4 float-end mt-4">{{ __('Login') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 ps-0 d-none d-md-block">
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
</div> --}}

@endsection