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

        .main-form {
            height: 400px;
        }
    </style>
@endpush
@extends('layouts.auth')

@section('content')
   <section class="one1">
        <div class="container">

            <div class="main">

                <div class="container">

                    <div class="signup-content">

                        <div class="signup-img">
                            <div class="logooo">
                                <a class="navbar-brand" href="#">
                                    <img src="{{asset('images/lg.png')}}" alt="" class="d-inline-block align-text-top">

                                </a>
                            </div>

                            <div class="logooo2">
                                <a class="navbar-brand" href="#">
                                    <img src="{{asset('images/yy.png')}}" alt="" class="d-inline-block align-text-top">
                                </a>
                            </div>




                            <div class="mn">
                                <img src="images/regg.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                       
                        <div class="signup-form">
                            <form method="post" action="{{ route('register') }}"  class="register-form"  id="register-form">
                                @csrf
                                <h2>{{ __('Register Form') }}</h2>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="company_name">{{ __('Company Name') }}:</label>
                                       
                                        <input id="company_name" type="text"
                                            class="form-control @error('company_name') is-invalid @enderror"
                                            name="company_name" value="{{ old('company_name') }}">
                                        @error('company_name')
                                            <div>
                                                <label class="error fail-alert  mt-1">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="city">{{ __('City') }} :</label>
                                       
                                        <input id="city" type="text"
                                            class="form-control @error('city') is-invalid @enderror" name="city"
                                            value="{{ old('city') }}">
                                        @error('city')
                                            <div>
                                                <label class="error fail-alert  mt-1">{{ $message }}</label>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="company_address">{{ __('Company Address') }} :</label>
                                    <input id="company_address" type="text"
                                        class="form-control @error('company_address') is-invalid @enderror"
                                        name="company_address" value="{{ old('company_address') }}">
                                    @error('company_address')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="company_phonenumber">{{ __('Company Phone Number') }}<span
                                            class="text-danger">*</span></label>
                               <input id="company_phonenumber" type="number"
                                        class="form-control @error('company_phonenumber') is-invalid @enderror"
                                        name="company_phonenumber" value="{{ old('company_phonenumber') }}">
                                    @error('company_phonenumber')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }} :</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}">

                                    @error('name')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="direct_number">{{ __('Direct Number') }}</label>
                                    <input id="direct_number" type="number" class="form-control @error('direct_number') is-invalid @enderror" name="direct_number" value="{{ old('direct_number') }}" >
                                    @error('direct_number')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="zip_code" class="form-label">{{ __('Zip Code') }}</label>
                                    <input id="zip_code" type="number"
                                        class="form-control @error('zip_code') is-invalid @enderror" name="zip_code"
                                        value="{{ old('zip_code') }}">
                                    @error('zip_code')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>



                                <div class="form-group">
                                    <label for="email">{{ __('Email Address') }} :</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}">

                                    @error('email')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        value="{{ old('password') }}">

                                    <small>Password must have at least 8 characters.</small>
                                    @error('password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group">

                                    <label for="password_confirmation"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password_confirmation" type="text"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" value="{{ old('password_confirmation') }}">

                                    <small>Password must have at least 8 characters.</small>
                                    @error('password_confirmation')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-submit">
                                    <button type="button" class="submit" name="reset"
                                        id="reset" >{{ __('Reset All') }}</button>
                                    <button type="submit" class="submit" name="submit"
                                        id="submit" >{{ __('Submit Form') }}</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
    </section>
@endsection

@push('footer_extras')
<script>
     $("#reset").click(function () {
        $('#register-form').find('input,select,textarea').val('');
    });
</script>
@endpush
