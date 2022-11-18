@push('header_extras')
    <style>
        a.btn.btn-primary {
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
        }
    </style>
@endpush

@extends('layouts.app')

@section('content')
    <div class="card mt-5">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Role</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary gg" href="{{ route('roles.index') }}"> Back </a>
                </div>
            </div>
        </div>


        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> something went wrong.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role]]) !!}
            @isset($role)
            <input type="hidden" name="id" value="{{encrypt($role->id)}}">
           @endisset
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                        {{-- <input type="text" value="{{@old('name',$role->name)}}" class="form-control  @error('name') {{ 'is-invalid' }} @enderror" id="name" name="name" placeholder="Name"> --}}
                              
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h5>Permission:</h5>
                </div>
                <br />

                @php
                    $permissionCount = count($permission);
                @endphp
                
                @foreach ($permission->slice(0, $permissionCount) as $value)
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>
                                {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }}
                                {{ $value->name }}</label>
                        </div>
                    </div>
                @endforeach

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
