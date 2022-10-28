@push('header_extras')
<style>
    .others {
        margin-left: 10px !important;
    }
</style>
@endpush

@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Add New Inspector') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="inspectorform" 
        action="@if(isset($data)) {{route('admin.update.inspector')}} 
        @else {{route('admin.insert.insertinspector')}} @endif" method="POST"> 
            @csrf

            @isset($data)
                <input type="hidden" name="id" value="{{encrypt($data->id)}}">
            @endisset
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-6 my-2">
                                <label for="name">{{ __('Name') }}</label>
                               <input type="text" value="{{@old('name',$data->name)}}" class="form-control  @error('name') {{ 'is-invalid' }} @enderror" id="name" name="name" placeholder="Name">
                               @error('name')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="company_name">{{ __('Company Name') }}</label>
                                <input type="text" value="{{@old('company_name',$data->company_name)}}" class="form-control    @error('company_name') {{ 'is-invalid' }} @enderror" id="company_name" name="company_name" placeholder="Company Name">
                                @error('company_name')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="number">{{ __('Phone Number') }}</label>
                                <input type="text" value="{{@old('number',$data->mobile_number)}}" class="form-control @error('number') {{ 'is-invalid' }} @enderror" id="number" name="number" placeholder="Phone Number">
                                @error('number')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="license_number">{{ __('License Number') }}</label>
                                <input type="text"  value="{{@old('license_number',$data->license_number)}}" class="form-control @error('license_number') {{ 'is-invalid' }} @enderror" id="license_number" name="license_number" placeholder="License Number">
                                @error('license_number')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                        
                            <div class="col-lg-6 my-2">
                                <label for="email">{{ __('Login Email') }}</label>
                                <input type="email"  value="{{@old('email',$data->email)}}" class="form-control  @error('email') {{ 'is-invalid' }} @enderror" id="email" name="email" placeholder="Email Address">
                                @error('email')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="password">{{ __('Login Password') }}</label>
                                <input type="password"  class="form-control @error('password') {{ 'is-invalid' }} @enderror" id="password" name="password" placeholder="Password">
                                @error('password')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                        
                            <div class="col-lg-6  my-2">
                                <label for="area_coverage">{{ __('Area of Coverage') }}</label>
                                <input type="text" value="{{@old('area_coverage',$data->area_coverage)}}" class="form-control @error('area_coverage') {{ 'is-invalid' }} @enderror" id="area_coverage" name="area_coverage" placeholder="Area of Coverage">
                                @error('area_coverage')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="color_code">{{ __('Color Code') }}</label>
                                <input type="color"  value="{{@old('color_code',$data->color_code)}}" class="form-control @error('color_code') {{ 'is-invalid' }} @enderror" id="color_code" name="color_code">
                                @error('color_code')
                                <div>
                                    <label class="error fail-alert  mt-1">{{ $message }}</label>
                                </div>
                                @enderror
                            </div>
                       
                        <!-- <p class="border-bottom mt-5"></p> -->
                            <!-- <h3>Custom Links</h3> -->
                            <!-- <small>The Custom Links are optional and will only be stored if both Title and Link is inputted.</small>
                            <div class="col-lg-6 my-2">
                                <label for="btn_title[]">{{ __('Button 1 Title') }}</label>
                                <input type="text" class="form-control" id="btn_title[]" name="btn_title[]" >
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_link[]">{{ __('Button 1 Link') }}</label>
                                <input type="text" class="form-control" id="btn_link[]" name="btn_link[]" >
                            </div>

                            <div class="col-lg-6 my-2">
                                <label for="btn_title[]">{{ __('Button 2 Title') }}</label>
                                <input type="text" class="form-control" id="btn_title[]" name="btn_title[]">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_link[]">{{ __('Button 2 Link') }}</label>
                                <input type="text" class="form-control" id="btn_link[]" name="btn_link[]">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_title[]">{{ __('Button 3 Title') }}</label>
                                <input type="text" class="form-control" id="btn_title[]" name="btn_title[]">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_link[]">{{ __('Button 3 Link') }}</label>
                                <input type="text" class="form-control" id="btn_link[]" name="btn_link[]">
                            </div>
                     
                            <div class="col-lg-6 my-2">
                                <label for="btn_title[]">{{ __('Button 4 Title') }}</label>
                                <input type="text" class="form-control" id="btn_title[]" name="btn_title[]" >
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_link[]">{{ __('Button 4 Link') }}</label>
                                <input type="text" class="form-control" id="[]" name="btn_link[]" >
                            </div>

                            <div class="col-lg-6 my-2">
                                <label for="btn_title[]">{{ __('Button 5 Title') }}</label>
                                <input type="text" class="form-control" id="btn_title[]" name="btn_title[]">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="btn_link[]">{{ __('Button 5 Link') }}</label>
                                <input type="text" class="form-control" id="btn_link[]" name="btn_link[]">
                            </div> -->
                        

                    </div>

                </div>

            </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
    </div>
    </form>
</div>
</div>
@endsection

