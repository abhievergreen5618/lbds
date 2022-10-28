@push('header_extras')
<style>
    .others {
        margin-left: 10px !important;
    }

    .profile-pic {
        color: transparent;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        transition: all 0.3s ease;
    }

    .profile-pic input {
        display: none;
    }

    .profile-pic img {
        position: absolute;
        object-fit: cover;
        width: 165px;
        height: 165px;
        box-shadow: 0 0 10px 0 rgba(255, 255, 255, .35);
        border-radius: 100px;
        z-index: 0;
    }

    .profile-pic .-label {
        cursor: pointer;
        height: 165px;
        width: 165px;
    }

    .profile-pic:hover .-label {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, .8);
        z-index: 10000;
        color: #fafafa;
        transition: background-color 0.2s ease-in-out;
        border-radius: 100px;
        margin-bottom: 0;
    }

    .profile-pic span {
        display: inline-flex;
        padding: 0.2em;
        height: 2em;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Profile') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary h-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('My Profile') }}</h3>
                        </div>
                        <form id="profile-form" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <div class="profile-pic">
                                        <label class="-label" for="file">
                                            <span class="glyphicon glyphicon-camera"></span>
                                            <span>Change Image</span>
                                        </label>
                                        <input id="file" type="file" name="profile_img" onchange="loadFile(event)" accept="image/*" />
                                        <img src="{{ (isset($data->profile_img)) ? asset('images/profile/').'/'.$data->profile_img : asset('images/profile/profile.jpg')}}" id="output" width="200" />
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" class="form-control @error('name') {{ 'is-invalid' }} @enderror" id="name" name="name" placeholder="Enter Inspection Name" value="{{@old('name',$data->name)}}">
                                </div>
                                @error('name')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">{{ __('Phone Number') }}</label>
                                    <input type="number" class="form-control @error('mobile_number') {{ 'is-invalid' }} @enderror" id="mobile_number" name="mobile_number" placeholder="Enter Phone Number" value="{{@old('mobile_number',(Auth::user()->hasRole('company')) ? $data->company_phonenumber : $data->mobile_number)}}">
                                    @error('mobile_number')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1">{{ __('Email Address') }}</label>
                                    <input type="email" class="form-control @error('email') {{ 'is-invalid' }} @enderror" id="email" name="email" placeholder="Enter Phone Number" value="{{@old('email',$data->email)}}" disabled>
                                    @error('email')
                                    <div>
                                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-2 text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary h-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Change Password') }}</h3>
                        </div>
                        <div class="card-body">
                            <form id="profile-form-password" action="{{route('profile.updatepass')}}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1">{{ __('Old password') }}</label>
                                        <input type="password" class="form-control @error('old_password') {{ 'is-invalid' }} @enderror" id="old_password" name="old_password" placeholder="Enter Phone Number">
                                        @error('old_password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1">{{ __('New password') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                        <div>
                                            <small>Password must have at least 8 characters.</small>
                                        </div>
                                        @error('password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                        <input id="password_confirmation" type="text" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                        @error('password_confirmation')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer_extras')
<script>
    var loadFile = function(event) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endpush