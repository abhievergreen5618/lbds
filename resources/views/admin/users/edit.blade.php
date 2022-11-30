@push('header_extras')
<style>
    /* a.btn.btn-primary {
        width: 100%;
        font-weight: 600;
        font-size: 20px;
    }

    .form-check-inline {
        display: block !important;
    }

    button.btn.btn-primary.btnnnnn {
        float: right;
    }

    h5.spacett {
        margin-top: 19px;
    } */
</style>
@endpush
@extends('layouts.app')

@section('content')
<!-- <div class="row mb-2">
    <div class="col-sm-6">
        <h4>Users</h4>
    </div>
    <div class="col-sm-12">
        <div class="float-left">
            <a class="btn btn-primary" href="{{ route('admin.users.view') }}"> Back</a>
        </div>
    </div>
</div> -->
<div class="card  card-primary mt-2">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="float-left">
                    <h3>Edit New User</h3>
                </div>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card-body">
        {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control','readonly'=>'readonly')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','readonly'=>'readonly')) !!}
                </div>
            </div>
            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
            </div> -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Role:</strong>
                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection