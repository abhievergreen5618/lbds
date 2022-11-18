@extends('layouts.auth')
@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Locked') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Unlock') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
        <div class="lockscreen-logo">
            <a href="https://windmitigationlogin.com"><b>Wind</b>Mitigation</a>
        </div>
        <!-- User name -->
        <div class="lockscreen-name">{{Auth::user()->name}}</div>

        <!-- START LOCK SCREEN ITEM -->
        <div class="lockscreen-item">
            <!-- lockscreen image -->
            <div class="lockscreen-image">
                <img src="{{ asset('images/profile/').'/'.Auth::user()->profile_img }}" alt="User Image">
            </div>
            <!-- /.lockscreen-image -->

            <!-- lockscreen credentials (contains the form) -->
            <form class="lockscreen-credentials" method="POST" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}">
                @csrf
                <div class="input-group">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="password">
                    <div class="input-group-append">
                        <button type="submit" class="btn">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </button>
                    </div>
                </div>
                @if($errors->has('password'))
                <div>
                    <label class="error fail-alert  mt-1">Your password does not match your profile.{{ $errors->first('password') }}</label>
                </div>
                @endif
            </form>
            <!-- /.lockscreen credentials -->

        </div>
        <!-- /.lockscreen-item -->
        <div class="help-block text-center">
            Enter your password to retrieve your session
        </div>
        <div class="text-center">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Or sign in as a different user</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        <div class="lockscreen-footer text-center">
            Copyright © <b><a href="https://windmitigationlogin.com/" class="text-black">Florida Wind Mitigation And Insurance Inspections</a></b><br>
            All rights reserved
        </div>
    </div>
</body>
@endsection