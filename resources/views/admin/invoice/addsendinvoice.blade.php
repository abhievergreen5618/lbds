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
            <h3 class="card-title">{{ __('Add Send Invoice Options') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="inspection-type-form" action="{{route('admin.create.createinspectiontype')}}" method="POST">
            @csrf
            @isset($data)
                <input type="hidden" name="id" value="{{encrypt($data->id)}}">
            @endisset
            <div class="card-body">
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
                    <label for="exampleInputEmail1">{{ __('Description') }}</label>
                    <textarea class="form-control @error('description') {{ 'is-invalid' }} @enderror" id="description" name="description" rows="3" placeholder="Enter ...">{{@old('name',$data->description)}}</textarea>
                    @error('description')
                    <div>
                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="">{{ __('Status') }}</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="active" value="active" @isset($data) @if($data['status'] == "active") {{"checked"}} @endif @endisset>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive"  @isset($data) @if($data['status'] == "inactive") {{"checked"}} @endif @endisset>
                        <label class="form-check-label" for="inactive">Inactive</label>
                    </div>
                    @error('status')
                    <div>
                        <label class="error fail-alert  mt-1">{{ $message }}</label>
                    </div>
                    @enderror
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection