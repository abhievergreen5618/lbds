@extends('layouts.app')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Compose</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Compose</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        @include('common.email.sidebar')
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Read Mail</h3>

            <div class="card-tools">
              <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
              <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="mailbox-read-info">
              <h5 class="mb-2">{{(!empty($readmail->subject) ? $readmail->subject : 'No Subject' )}}</h5>
              <h6 class="my-2">To : {{(!empty($readmail->mailto) ? implode(',',$readmail->mailto) : '')}}<span class="mailbox-read-time float-right">{{ date('F d ,Y h:i a',strtotime($readmail->updated_at))}}</span></h6>
              @if(!empty($readmail->mailcc)) <h6 class="my-2">CC : {{implode(',',$readmail->mailcc)}}</h6> @endif
              @if(!empty($readmail->mailbcc)) <h6 class="my-2">CC : {{implode(',',$readmail->mailbcc)}}</h6> @endif
            </div>
            <!-- /.mailbox-read-info -->
            <!-- <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                    <i class="fas fa-share"></i>
                  </button>
                </div> -->
            <!-- /.btn-group -->
            <!-- <button type="button" class="btn btn-default btn-sm" title="Print">
                  <i class="fas fa-print"></i>
                </button>
              </div> -->
            <!-- /.mailbox-controls -->
            <div class="mailbox-read-message">
              @php
              echo (!empty($readmail->message) ? $readmail->message : 'No Message');
              @endphp
            </div>
            <!-- /.mailbox-read-message -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer bg-white">
            <ul class="mailbox-attachments d-flex align-items-stretch clearfix overflow-auto">
              @if(!empty($readmail->attachments))
              @foreach($readmail->attachments as $item)
              @php
              $info = pathinfo(public_path('taskfiles') . $item);
              $ext = $info['extension'];
              $fileSize =Storage::disk('taskfiles')->size($item);
              $fileSize = $mailhelper->formatBytes( $fileSize );
              @endphp
              @if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg')
                <li>
                  <span class="mailbox-attachment-icon has-img">
                    <img src="{{asset('taskfiles').'/'.$item}}" alt="Attachment"></span>
                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i>{{$item}}</a>
                    <span class="mailbox-attachment-size clearfix mt-1">
                      <span>{{$fileSize}}</span>
                      <a href="{{route('filedownload',['filename' => $item])}}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                    </span>
                  </div>
                </li>
              @else
                <li>
                  <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                  <div class="mailbox-attachment-info">
                    <a href="{{asset('taskfiles').'/'.$item}}" target="blank" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{$item}}</a>
                    <span class="mailbox-attachment-size clearfix mt-1">
                      <span>{{$fileSize}}</span>
                      <a href="{{route('filedownload',['filename' => $item])}}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                    </span>
                  </div>
                </li>
              @endif
              @endforeach
              @endif
            </ul>
          </div>
          <!-- /.card-footer -->
          <div class="card-footer">
            <div class="float-right">
              <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
              <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
            </div>
            <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
            <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

@endsection