@push('header_extras')
<style>
 .main{
  margin-top: -11% !important;
 }
  .textterror {
    padding: 80px;
  }

  .textterror.ps-5 {
    margin-top: 20%;
    margin-bottom: 10%;
  }

  .title {
    font-size: 55px;
    font-weight: 700;
    text-align: center;
    color: red;
  }

  .subtitle {
    text-align: center;
    font-size: 30px;
    font-weight: 500;
  }

  a.button {
    background-color: red;
    border-radius: 38px;
    padding: 20px;
    text-decoration: none;
    color: white;
    font-weight: 500;
  }

  .isi {
    text-align: center;
  }

  .isi {
    font-weight: 500;

  }
</style>
@endpush
@extends('layouts.auth')
@section('content')
@php
use App\Models\Options;
$options= new Options();
@endphp
<section class="one1">
  <!-- <div class="container"> -->
    <div class="main">
      <div class="textterror ps-5 ">
        <div class="title" data-content="401">
        {{ __('401 - Unauthorized') }}
        </div>
        <div class="subtitle">
        {{ __('Oops, You are not authorized for these.')}}
        </div>
        <div class="isi">
        {{ __('For Accessing these you may contact with Administrative Department.')}}
          <p><i class="fa fa-regular fa-envelope"></i>&nbsp;{{$options->get_option('mail_from_address')}}</p>
        </div>
        <div class="buttons mt-5 text-center">
          <a class="button" href="{{route('home')}}">{{ __('Go to homepage')}}</a>
        </div>
      </div>
    </div>
  <!-- </div> -->
</section>
@endsection