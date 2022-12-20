@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))


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
        <div class="title" data-content="503">
        {{ __('503 - Service Unavailable') }}
        </div>
        <div class="subtitle">
        {{ __('Service unavailable!')}}
        </div>
        <div class="isi">
        {{ __('Please try again later.')}}
        </div>
        <div class="buttons mt-5 text-center">
          <a class="button" href="{{route('home')}}">{{ __('Go to homepage')}}</a>
        </div>
      </div>
    </div>
  <!-- </div> -->
</section>
@endsection