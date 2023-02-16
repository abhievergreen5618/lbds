@php
use App\Models\User;
use App\Models\RequestModel;
use Illuminate\Support\Facades\DB;
$total_assigned_request=RequestModel::where(['assigned_ins'=>Auth::user()->id,'status'=>'assigned'])->count();
$total_scheduled_request=RequestModel::where(['assigned_ins'=>Auth::user()->id,'status'=>'scheduled'])->count();
$total_underreview_request=RequestModel::where(['assigned_ins'=>Auth::user()->id,'status'=>'underreview'])->count();
$total_completed_request=RequestModel::where(['assigned_ins'=>Auth::user()->id,'status'=>'completed'])->count();
@endphp
@extends('layouts.app')
@section("content")
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$total_assigned_request}}</h3>
                        <p>Assigned Request</p>
                    </div>
                    <a href="{{route('inspector.request.list',['status'=>'assigned'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$total_scheduled_request}}</h3>
                        <p>Scheduled Requests</p>
                    </div>
                    <a href="{{route('inspector.request.list',['status'=>'scheduled'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner text-white">
                        <h3>{{$total_underreview_request}}</h3>
                        <p>Submitted for Review Requests</p>
                    </div>
                    <a href="{{route('inspector.request.list',['status'=>'underreview'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$total_completed_request}}</h3>
                        <p>Completed Requests</p>
                    </div>
                    <a href="{{route('inspector.request.list',['status'=>'completed'])}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</section>
@endsection



