@extends('layouts.auth')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="section one11">
    <div class="col-md-6 gh">
        <a class="navbar-brand tttt" href="#">
            <img src="{{asset('images/largee.png')}}" alt="" class="img-fluid" class="d-inline-block align-text-top">
        </a>
        <div class="card">
            <div class="card-header bg-green">
                <div class="small text-white fw-500">{{ __('Verify Your Email Address') }}</div>
            </div>
            <div class="list-group list-group-flush small mb-0 border-bottom"><a class="list-group-item list-group-item-action">{{ __('Before proceeding, please check your email for a verification link.') }}
                    <br>{{ __('If you did not receive the email') }},
                </a>
                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif
                    <div class="d-grid">
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <div class="w-100 text-center">
                                <button type="submit" class="btn btn-green-soft text-green fw-500">{{ __('click here to request another') }}</button>.
                            </div>
                        </form>
                    </div>
                </div>
</div>
@endsection