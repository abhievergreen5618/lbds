@push('header_extras')
<style>
    a {
        text-decoration: none;
    }

    .login-page {
        width: 100%;
        height: 100vh;
        display: inline-block;
        display: flex;
        align-items: center;
    }

    .form-right i {
        font-size: 100px;
    }
</style>
@endpush
@extends('layouts.auth')
@section('content')
<section class="vh-100 one1">
    <section class="content text-center">
        <div class="error-page">
        <h2 class="headline text-danger">403</h2>
        <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops!Access Denied.</h3>
        <p>You are trying to access wrong chat
         <a href="{{route('chatify-index')}}" class="nav-link"><p>Back</p></a>
        </p>
        </p>
        </div>
        </div>

        </section>
</section>
@endsection
