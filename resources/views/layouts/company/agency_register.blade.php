@extends('layouts.master')
@section('content')
<div class="container">
    <div class="container-fluid">
        <div class="row">
            {{-- logo-section --}}
            <div class="col-md-6">
            </div>
            {{-- form section --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form>
                           <h2><b>Create an Account</b></h2>
                           <p class="border-bottom" style="color:red;">*All Fields are required.</p>

                                <div class="col form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" name="company_name"  requierd>
                                    {{-- {{ Form::label('company_name','Company Name')}}
                                    {{ Form::text('company_name',['class'=>'form-control']) }} --}}
                                </div>
                                <div class="col form-group">
                                    <label for="company_address">Company Address</label>
                                    <input type="text" class="form-control" name="company_address"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="zip_code">Zip Code</label>
                                    <input type="text" class="form-control" name="zip_code"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="company_phonenumber">Company Phone Number</label>
                                    <input type="text" class="form-control" name="company_phonenumber"  requierd>
                                </div>
                                <p class="border-bottom mt-5"></p>

                                <div class="col form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="direct_number">Direct Number</label>
                                    <input type="text" class="form-control" name="direct_number"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="email">Email Address</label>
                                    <input type="text" class="form-control" name="email"  requierd>
                                </div>
                                <div class="col form-group">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" name="password"  requierd>
                                    <small>Password must have at least 6 characters.</small>
                                </div>
                                <p>By clicking Register, you agree to our <a href="#">terms of service</a> and <a href="#">privacy policy</a></p>

                                <div class="col form-group text-center">
                                    <button class="btn btn-danger">Submit</button>
                                </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
