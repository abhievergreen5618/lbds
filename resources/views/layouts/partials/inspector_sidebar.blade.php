<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">WINDMITIGATION</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
            <div class="info">
                <a href="#" class="d-block">{{ ucfirst(Auth::user()->name) }}</a>
            </div>
        </div>

    

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

             
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
    

                @can('request-list')
                <li class="nav-item">
                    <a href="{{route('inspector.request.list')}}" class="nav-link">
                        <i class="nav-icon fas fa-align-left"></i>
                        <p>
                            Requests
                        </p>
                    </a>
                </li>
                @endcan

                {{-- @can('') --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Job Calender
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                  {{-- @can('') --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-align-left"></i>
                        <p>
                            Completed Request
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                {{-- @can('') --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                           Content
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                {{-- @can('') --}}
                <li class="nav-item">
                    <a href="{{ route('chatify-index') }}" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Messages
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}


                {{-- @can('') --}}
                <li class="nav-item">
                    <a href="{{route('profile.show')}}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                  {{-- @can('') --}}
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                           Change Password
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                  {{-- <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" >
                        <i class="nav-icon fas fa-sign-out-alt" ></i>
                        <p>
                          Logout
                        </p>
                    </a>
                </li> --}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@yield('sidebar')

<!-- Content Wrapper. Contains page content -->
