@push('header_extras')
@endpush
@extends('layouts.app')

@section('content')
<div class="col-md-12">
         <div class="card card-primary h-100">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Change Password') }}</h3>
                        </div>
                        <div class="card-body">
                            @isset($data)
                                <input type="hidden" name="id" value="{{encrypt($data->id)}}">
                                @endisset
                            <form id="forget-password" action="{{route('admin.agency.Updatepassword',['id'=>encrypt($data->id)])}}" method="POST">
                                @csrf
                                
                                <div class="card-body">
                                    <!-- <div class="form-group mb-2">
                                        <label for="exampleInputEmail1">{{ __('Old password') }}</label>
                                        <input type="password" class="form-control @error('old_password') {{ 'is-invalid' }} @enderror" id="old_password" name="old_password" placeholder="Enter Current Password">
                                        @error('old_password')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{ $message }}</label>
                                        </div>
                                        @enderror
                                    </div> -->
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
          
@endsection
@push('footer_extras')

@endpush