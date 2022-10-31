<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{ asset('public/images/logo.png') }}" alt="Logo" class="elevation-3" style="max-height: 28px !important;">
        {{-- <span class="brand-text font-weight-light">WINDMITIGATION</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
            <div class="info">
                <a href="{{route('home')}}" class="d-block">{{ ucfirst(Auth::user()->name) }}</a>
            </div>
        </div>

    
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : ''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Employee
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                         
                        @can('employee-create')
                        <li class="nav-item">
                            <a href="{{route('admin.employee.create')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Add new Employee
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('employee-list')
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    View All Employees
                                </p>
                            </a>
                        </li>
                        @endcan

                        {{-- @can('') --}}
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>
                                    Employees Messages
                                </p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                    </ul>
                </li>
                {{-- @role('company') --}}
                {{-- <li class="nav-item {{ (Route::currentRouteName() == 
                    'admin.request.create' ) ? 'menu-open menu-is-opening ' : ''}}">

                    <a href="#"  class="nav-link {{ (Route::currentRouteName() == 
                    'admin.request.create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Roles & Permission
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() == 
                        'admin.request.create') ? 'display: block;' : ''}}">

                        @can('role-list')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link {{str_contains(request()->path(), 'admin.request.create') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Manage Role
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('role-create')
                        <li class="nav-item">
                            <a href="{{ route('roles.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Add Roles
                                </p>
                            </a>
                        </li>
                        @endcan

                    </ul>
                </li> --}}
                {{-- @endrole --}}

                <li class="nav-item {{ (Route::currentRouteName() == 
                    'admin.request.create' ) ? 'menu-open menu-is-opening ' : ''}}">

                    <a href="#" class="nav-link {{ (Route::currentRouteName() == 
                    'admin.request.create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Requests
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() == 
                        'admin.request.create') ? 'display: block;' : ''}}">
                        
                        @can('request-create')
                        <li class="nav-item">
                            <a href="{{route('admin.request.create')}}" class="nav-link {{str_contains(request()->path(), 'admin.request.create') ? 'active' : ''}}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Add new Request
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('request-list')
                        <li class="nav-item">
                            <a href="{{route('company.request.list')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    View All Requests
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                
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

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@yield('sidebar')

<!-- Content Wrapper. Contains page content -->
