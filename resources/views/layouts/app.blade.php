<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/toastr/toastr.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('/plugins/summernote/summernote-bs4.min.css')}}">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{asset('/plugins/fullcalendar/main.css')}}">
  {{-- bs-stepper --}}
  <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">

  <link rel="stylesheet" href="{{asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('/css/datatableselect.min.css')}}"> -->
  <link rel="stylesheet" href="{{asset('/css/sweetalert.min.css')}}">
  <link rel="stylesheet" href="{{asset('/css/dropzone.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/summernote/summernote-bs4.min.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}"> -->
  <link rel="stylesheet" href="{{asset('/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/css/style.css')}}">
  <style>
  .toast {
    background-color: rgba(255, 255, 255, 0.85);
    }
</style>
  @stack("header_extras")
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('layouts.partials.loader')
    @include('layouts.partials.header')
    @role('admin')
    @include('layouts.partials.admin_sidebar')
    @endrole
    @role('inspector')
    @include('layouts.partials.inspector_sidebar')
    @endrole
    @role('company')
    @include('layouts.partials.company_sidebar')
    @endrole
    @role('employee')
    @include('layouts.partials.company_sidebar')
    @endrole
    <div class="content-wrapper" style="min-height: 214px;">
      <div class="container-fluid mt-2">
        @include('layouts.partials.alert')
        @yield("content")
      </div>
    </div>
    @include('layouts.partials.footer')


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('/plugins/toastr/toastr.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="{{asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('/plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('/plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('/dist/js/demo.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
  <script src="{{ asset('/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
  <script src="{{asset('/dist/js/pages/dashboard.js')}}"></script>
  <script src="{{asset('/js/validation.min.js')}}"></script>
  <script src="{{asset('/js/validate.js')}}"></script>
  <script src="{{asset('/js/popper.min.js')}}"></script>
  <script src="{{asset('/js/tooltip.min.js')}}"></script>
  <script src="{{asset('/plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('/plugins/fullcalendar/main.js')}}"></script>
  <script src="{{asset('/js/clipboard.min.js')}}"></script>
  <script src="{{asset('/js/sweetalert.min.js')}}"></script>
  <script src="{{asset('/js/dropzone.min.js')}}"></script>
  <script src="{{asset('/plugins/summernote/summernote-bs4.min.js')}}"></script>
  <script src="{{asset('/plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <!-- <script src="{{asset('/js/dataTableselect.min.js')}}"></script> -->
  <script src="{{asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('/js/functions.js')}}"></script>
  <script src="{{asset('/js/custom.js')}}"></script>
  @stack("footer_extras")
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('cdb5dfb1da13d59428cd', {
      cluster: 'us3'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // console.log(data.unreadmessages);
      var attactchment = '';
      if (data.message.attachment[0] == null && data.message.attachment[1] == null && data.message.attachment[2] == null) {
        attactchment = '';
      } else {
        attactchment = '<i class="text-primary fa fa-paperclip">Attachment</i>';
      }
      playAudio();
      $("#messagesCount").html(
        '<i class="far fa-comments"></i><span class="badge badge-danger navbar-badge">' + data
        .messagesCount + '</span>');
      $("#message-notification").prepend('<a href="/chatify/' + data.from_id +
        '" class="dropdown-item"><div class="media"><img src="images/profile/' + data.profile_img +
        '" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body"><h3 class="dropdown-item-title">' +
        data.name + '</h3><p class="text-sm">' + data.message.message + '</p><p>' + attactchment +
        '</p><span class="text-center text-danger">' +
        data.unreadmessages + '&nbsp;Unread</span> ' +
        '</div></div></a><div class="dropdown-divider"></div>');
        var link = "/chatify/"+data.from_id;
          $(document).Toasts('create', {
            body: data.message.message,
            title: "<a href='"+link+"' target='_blank'>"+data.name+"</a>",
            icon: 'fas fa-envelope fa-lg',
          });
    });


    function playAudio() {
      var sound = new Audio('{{ asset('audio/sound.mp3')}}');
      var playPromise = sound.play();
      if (playPromise !== undefined) {
        playPromise.then(_ => {
            sound.play();
          })
          .catch(error => {});
      }
    }
  </script>
</body>

</html>
