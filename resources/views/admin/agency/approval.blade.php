@extends('layouts.auth')

@section('content')

<div class="section one11">

    <div class="col-md-6 gh">

        <a class="navbar-brand tttt" href="#">
            <img src="{{asset('images/largee.png')}}" alt="">

        </a>

             <div class="card">
                <div class="card-body">
                  
                        <div class="alert alert-danger" role="alert">
                            {{ __('Please wait for Approval.') }}
                        </div>
             </div>
                        

        </div>
</div>
            @endsection