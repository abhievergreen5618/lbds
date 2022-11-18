@php
    use Illuminate\Support\Facades\DB;
    use carbon\carbon;
    use App\Models\ChMessage;
    $messagesList = DB::table('ch_messages')
        ->join('users', 'users.id', '=', 'ch_messages.from_id')
        ->where('to_id', Auth::user()->id)
        ->where('seen', '0')
        ->take(3)
        ->groupBy('ch_messages.from_id')
        ->get();
    $messagesCount = count($messagesList);
    
    $messages = DB::table('ch_messages')
        ->where('to_id', Auth::user()->id)
        ->where('seen', '0')
        ->get();
    $msgCount = count($messages);
    
    function countMessages($id){
        $unreadmsgs=ChMessage::where('from_id', $id)->where('seen','0')->count();
     return  $unreadmsgs;
    }

@endphp
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown" id="message-notification-count" id="message-notification">
            <a class="nav-link" data-toggle="dropdown" href="#" id="messagesCount">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">{{  $msgCount }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="message-notification">
                @foreach ($messagesList as $value)
            
                    <a href="{{ route('chatify') . '/' . $value->from_id }}" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <img src="{{ asset('images/profile/') . '/' . $value->profile_img }}" alt="User Avatar"
                                class="img-size-50 mr-3 img-circle">
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    {{ $value->name }}
                                </h3>
                                <p class="text-sm">{{ $value->body }}</p>
                                <span class="text-center text-danger">{{ countMessages($value->from_id) }}&nbsp;Unread</span>
                                <p class="text-sm text-muted"><i
                                        class="far fa-clock mr-1"></i>{{ Carbon::parse($value->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach

                @role('admin')
                    <a href="{{ route('chatify') }}" class="dropdown-item dropdown-footer">See All Messages</a>
                @endrole
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-cog"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        {{-- Profile popup --}}
        <li class="nav-item dropdown user user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                @php $imglink = (!empty(Auth::user()->profile_img)) ? asset('images/profile/').'/'.Auth::user()->profile_img : asset('images/profile/profile.jpg'); @endphp
                <img src="{{ $imglink }}" class="user-image" alt="User Image">
                <span class="hidden-xs">{{ ucfirst(Auth::user()->name) }}</span>
            </a>
            <ul class="dropdown-menu">

                <li class="user-header">
                    <img src="{{ $imglink }}" class="img-circle" alt="User Image">
                    <p>
                        {{ ucfirst(Auth::user()->name) }}
                        {{-- <small>Member since Nov. 2012</small> --}}
                    </p>
                </li>
                <div class="dropdown-divider"></div>
                <li class="text-center">
                    {{ ucfirst(Auth::user()->email) }}

                </li>
                <div class="dropdown-divider"></div>
                <li class="user-footer">
                    <div class="float-left">
                        <a href="{{ route('profile.show') }}" class="btn btn-primary btn-flat">Profile</a>
                    </div>
                    <div class="float-right">
                        {{-- <a href="#" class="btn btn-danger btn-flat">Sign out</a> --}}

                        <a class="btn btn-danger btn-flat" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
@yield('navbar')
