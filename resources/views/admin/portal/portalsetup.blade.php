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
                <h3 class="card-title">{{ __('Website Configuration') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary h-100">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Website Profile') }}</h3>
                            </div>
                            <form id="websiteconfigurationform" action="{{ route('portal.update.website') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <div class="profile-pic">
                                                    <label class="-label" for="file">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Change Image</span>
                                                    </label>
                                                    <input id="file" type="file" name="website_logo"
                                                        onchange="loadFile(event)" accept="image/*" />
                                                    <img src="{{ asset('images/') . '/' . $data['website_logo'] }}"
                                                        id="output" width="200" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <div class="profile-pic">
                                                    <label class="-label" for="file_logo">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Change Logo</span>
                                                    </label>
                                                    <input id="file_logo" type="file" name="website_second_logo"
                                                        onchange="loadLogoFile(e)" accept="image/*" />
                                                    <img src="{{ asset('images/') . '/' . $data['website_second_logo'] }}"
                                                        id="output_logo" width="200" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text"
                                            class="form-control @error('name') {{ 'is-invalid' }} @enderror" id="website_name"
                                            name="name" value="{{ @old('name', $data['website_name']) }}">
                                    </div>
                                    @error('name')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                    @enderror
                                    <div class="form-group mb-2">
                                        <label for="exampleInputEmail1">{{ __('Email Address') }}</label>
                                        <input type="email"
                                            class="form-control @error('email') {{ 'is-invalid' }} @enderror"
                                            id="email" name="website_email"
                                            value="{{ @old('email', $data['website_email']) }}">
                                        <div>
                                            <small>This is where you will be receiving emails.</small>
                                        </div>
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
                                <h3 class="card-title">{{ __('Mail Configuration') }}</h3>
                            </div>
                            <div class="card-body">
                                <form id="emailconfiguration" action="{{ route('portal.update.mail') }}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group mb-2">
                                            <label for="mail_host">{{ __('MAIL HOST') }}</label>
                                            <input type="text"
                                                class="form-control @error('mail_host') {{ 'is-invalid' }} @enderror"
                                                id="mail_host" name="mail_host"
                                                value="{{ @old('mail_host', $data['mail_host']) }}">
                                            @error('mail_host')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="mail_port">{{ __('MAIL PORT ') }}</label>
                                            <input type="text"
                                                class="form-control @error('mail_port') is-invalid @enderror" id="mail_port"
                                                name="mail_port" value="{{ @old('mail_port', $data['mail_port']) }}">
                                            @error('mail_port')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="mail_username">{{ __('MAIL USERNAME') }}</label>
                                            <input type="text"
                                                class="form-control @error('mail_username') is-invalid @enderror"
                                                id="mail_username" name="mail_username"
                                                value="{{ @old('mail_username', $data['mail_username']) }}">
                                            @error('mail_username')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="mail_password">{{ __('MAIL PASSWORD') }}</label>
                                            <input type="text"
                                                class="form-control @error('mail_password') is-invalid @enderror"
                                                id="mail_password" name="mail_password"
                                                value="{{ @old('mail_password', $data['mail_password']) }}">
                                            @error('mail_password')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="mail_address">{{ __('MAIL FROM ADDRESS') }}</label>
                                            <input type="email"
                                                class="form-control @error('mail_address') is-invalid @enderror"
                                                id="mail_address" name="mail_address"
                                                value="{{ @old('mail_address', $data['mail_address']) }}">
                                            @error('mail_address')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="mail_encryption">{{ __('MAIL ENCRYPTION') }}</label>
                                            <input type="text"
                                                class="form-control @error('mail_encryption') is-invalid @enderror"
                                                id="mail_encryption" name="mail_encryption"
                                                value="{{ @old('mail_encryption', $data['mail_encryption']) }}">
                                            @error('mail_encryption')
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
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="card card-primary h-100">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Pusher Configuration') }}</h3>
                            </div>
                            <div class="card-body">
                                <form id="pusherconfiguration" action="{{ route('portal.update.pusher') }}"
                                    method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group mb-2">
                                            <label for="pusher_app_id">{{ __('PUSHER APP ID') }}</label>
                                            <input type="text"
                                                class="form-control @error('pusher_app_id') {{ 'is-invalid' }} @enderror"
                                                id="pusher_app_id" name="pusher_app_id"
                                                value="{{ @old('pusher_app_id', $data['pusher_app_id']) }}">
                                            @error('pusher_app_id')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="pusher_app_key">{{ __('PUSHER APP KEY') }}</label>
                                            <input type="text"
                                                class="form-control @error('pusher_app_key') {{ 'is-invalid' }} @enderror"
                                                id="pusher_app_key" name="pusher_app_key"
                                                value="{{ @old('pusher_app_key', $data['pusher_app_key']) }}">
                                            @error('pusher_app_key')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="pusher_app_secret">{{ __('PUSHER APP SECRET') }}</label>
                                            <input type="text"
                                                class="form-control @error('pusher_app_secret') {{ 'is-invalid' }} @enderror"
                                                id="pusher_app_secret" name="pusher_app_secret"
                                                value="{{ @old('pusher_app_secret', $data['pusher_app_secret']) }}">
                                            @error('pusher_app_secret')
                                                <div>
                                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="pusher_app_cluster">{{ __('PUSHER APP CLUSTER') }}</label>
                                            <input type="text"
                                                class="form-control @error('pusher_app_cluster') {{ 'is-invalid' }} @enderror"
                                                id="pusher_app_cluster" name="pusher_app_cluster"
                                                value="{{ @old('pusher_app_cluster', $data['pusher_app_cluster']) }}">
                                            @error('pusher_app_cluster')
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
                    <div class="col-md-6">
                        <div class="card card-primary h-100">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Website Image Update') }}</h3>
                            </div>
                            <form id="websiteimageconfigurationform" action="{{ route('portal.update.image') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <div class="profile-pic">
                                                    <label class="-label" for="login_img">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Login Image</span>
                                                    </label>
                                                    <input id="login_img" type="file" name="login_img"
                                                        onchange="loadFile(e)" accept="image/*" />
                                                    <img src="{{ asset('images/') . '/' . $data['login_img'] }}"
                                                        id="login_img" width="200" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <div class="profile-pic">
                                                    <label class="-label" for="registration_img">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span>Registration Image</span>
                                                    </label>
                                                    <input id="registration_img" type="file" name="registration_img"
                                                        onchange="loadFile(e)" accept="image/*" />
                                                    <img src="{{ asset('images/') . '/' . $data['registration_img'] }}"
                                                        id="registration_img" width="200" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <div class="profile-pic">
                                                    <label class="-label" for="registration_logo_img">
                                                        <span class="glyphicon glyphicon-camera"></span>
                                                        <span> Registration Logo</span>
                                                    </label>
                                                    <input id="registration_logo_img" type="file"
                                                        name="registration_logo_img" onchange="loadFile(e)"
                                                        accept="image/*" />
                                                    <img src="{{ asset('images/') . '/' . $data['registration_logo_img'] }}"
                                                        id="registration_logo_img" width="200" />
                                                </div>
                                            </div>
                                        </div>
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
@endsection

@push('footer_extras')
    <script>
        var loadFile = function(event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        var loadLogoFile = function(e) {
            var image = document.getElementById("output_logo");
            image.src = URL.createObjectURL(e.target.files[0]);
        };
        var loadFile = function(e) {
            var image = document.getElementById("login_img");
            image.src = URL.createObjectURL(e.target.files[0]);
        };
        var loadFile = function(e) {
            var image = document.getElementById("registration_img");
            image.src = URL.createObjectURL(e.target.files[0]);
        };
        var loadFile = function(e) {
            var image = document.getElementById("registration_logo_img");
            image.src = URL.createObjectURL(e.target.files[0]);
        };

    </script>
@endpush
