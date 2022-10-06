@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Submit New Request') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form>
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-12">
                            <label for="" class="form-label">{{__('Select Inspection Type')}}</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{__('Checkbox')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{__('Checkbox')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{__('Checkbox')}}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox">
                            <label class="form-check-label">{{__('Checkbox')}}</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Insured / Applicant Information') }}</label>
                            </div>
                            <div class="col-lg-6">
                            <label for="exampleInputPassword1">{{ __('Email address') }}</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="col-lg-6">
                            <label for="exampleInputPassword1">{{ __('Email address') }}</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="col-lg-6">
                            <label for="exampleInputPassword1">{{ __('Email address') }}</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="col-lg-6">
                            <label for="exampleInputPassword1">{{ __('Email address') }}</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection