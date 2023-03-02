@php

use App\Models\Options;
$option = new Options;
$loginimage = $option->get_option("login_img");
@endphp

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
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-3 mb-0">{{ __('Or') }}</p>
                </div>
              <p class="small fw-bold my-3 pt-1 mb-0">Don't have an account? <a href="{{ route('register') }}"
                  class="link-danger">{{ __('Register') }}</a></p>
            </div>
  
          </form>
        </div>
        <div class="col-md-9 col-lg-6 col-xl-5">
          <img src="{{asset('images/'.$loginimage)}}"
            class="img-fluid" alt="Sample image">
        </div>
      </div>
    </div>
  </section>

@endsection