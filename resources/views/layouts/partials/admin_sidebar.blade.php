@php
$menuoptions =
[
"Dashboard" => ["route" => route('home'),"submenu" => 0,"iconclass" => "nav-icon fas fa-home","routename" => ["home"],"permission" => ""],
"Inspection" => [
"route" => "#",
"routename" => ["admin.create.addinspectiontype","admin.allinspectiontype"],
"submenu" => 1,
"iconclass" => "nav-icon fa fa-sharp fa-solid fa-bars",
"permission"=>"",
"submenulist" => [
"Add Inspection Type" => ["route"=>route('admin.create.addinspectiontype'),"permission"=>"inspection-create","iconclass" => "nav-icon fa fa-sharp fa-solid fa-bars"],
"View All Inspection Type" => ["route"=>route('admin.allinspectiontype'),"permission"=>"inspection-create","iconclass" => "nav-icon fa fa-sharp fa-solid fa-bookmark"],
]
],
];


use Illuminate\Support\Facades\DB;
$pendingCount= DB::table('users')->where('approved','Pending')->count();
$disapprovedCount= DB::table('users')->where('approved','Disapproved')->count();
@endphp
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img
            src="{{ asset('public/images/logo.png') }}"
            alt="Logo"
            class="elevation-3"
            style="max-height: 28px !important;"
        >
        {{--
        <span class="brand-text font-weight-light">WINDMITIGATION</span>
        --}}
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">{{ ucfirst(Auth::user()->name) }}</a>
            </div>
        </div>
        {{-- sidebar --}}
        <nav class="mt-2">
            <ul
                class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false"
            >
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link {{  (Route::currentRouteName() == 'home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(Gate::check('inspection-create') || Gate::check('inspection-list'))
                <li class="nav-item {{ (Route::currentRouteName() ==
'admin.create.addinspectiontype' || Route::currentRouteName() ==
'admin.allinspectiontype') ? 'menu-open menu-is-opening' : '' }}">
                    <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.create.addinspectiontype'||
Route::currentRouteName() == 'admin.allinspectiontype') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-sharp fa-solid fa-bars"></i>
                        <p>
                            Inspection
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() ==
'admin.create.addinspectiontype'||
Route::currentRouteName() == 'admin.allinspectiontype') ? 'display: block;' : ''}}">
                        @can('inspection-create')
                        <li class="nav-item">
                            <a href="{{route('admin.create.addinspectiontype')}}" class="nav-link">
                                <i class="nav-icon fa  fa-file-invoice fa-thin fas"></i>
                                <p>
                                    Add Inspection Type
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('inspection-list')
                        <li class="nav-item">
                            <a href="{{route('admin.allinspectiontype')}}" class="nav-link">
                                <i class="nav-icon fa fa-sharp fa-solid fa-bookmark"></i>
                                <p>
                                    View All Inspection Type
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Gate::check('sendinvoice-create') || Gate::check('sendinvoice-list'))
                <li class="nav-item {{ (Route::currentRouteName() ==
'admin.create.addsendinvoice' || Route::currentRouteName() ==
'admin.allsendinvoice') ? 'menu-open menu-is-opening' : '' }}">
                    <a href="#" class="nav-link {{ (Route::currentRouteName() == 'admin.create.addsendinvoice'||
Route::currentRouteName() == 'admin.allsendinvoice') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-edit"></i>
                        <p>
                            SendInvoice
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() ==
'admin.create.addsendinvoice'||
Route::currentRouteName() == 'admin.allsendinvoice') ? 'display: block;' : ''}}">
                        @can('sendinvoice-create')
                        <li class="nav-item">
                            <a href="{{route('admin.create.addsendinvoice')}}" class="nav-link">
                                <i class="nav-icon fa  fa-file-invoice fa-thin fas"></i>
                                <p>
                                    Add Send Invoice
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('sendinvoice-list')
                        <li class="nav-item">
                            <a href="{{route('admin.allsendinvoice')}}" class="nav-link">
                                <i class="nav-icon fa fa-solid fa-file-contract"></i>
                                <p>
                                    View All SendInvoice
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Gate::check('request-create') || Gate::check('request-list'))
                <li class="nav-item {{ (Route::currentRouteName() ==
'admin.request.create' || Route::currentRouteName() ==
'admin.request.list') ? 'menu-open menu-is-opening ' : ''}}">
                    <a href="#" class="nav-link {{ (Route::currentRouteName() ==
'admin.request.create' || Route::currentRouteName() ==
'admin.request.list') ? 'active' : ''}}">
                        <i class="nav-icon fa fa-sharp fa-solid fa-file"></i>
                        <p>Requests
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() ==
    'admin.request.create' || Route::currentRouteName() ==
    'admin.request.list' ) ? 'display: block;' : ''}}">
                        @can('request-create')
                        <li class="nav-item">
                            <a href="{{route('admin.request.create')}}" class="nav-link">
                                <i class="nav-icon fa fa-file-signature"></i>
                                <p>
                                    Add new Request
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('request-list')
                        <li class="nav-item">
                            <a href="{{route('admin.request.list')}}" class="nav-link">
                                <i class="nav-icon fa fa-file-alt"></i>
                                <p>
                                    View All Requests
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Gate::check('user-create') || Gate::check('user-list'))
                <li class="nav-item {{ (Route::currentRouteName() ==
                        'users.create') ||
                        (Route::currentRouteName() == 'admin.users.view') ? 'menu-open menu-is-opening ' : ''}}">
                    <a href="#" class="nav-link {{ (Route::currentRouteName() ==
                        'users.create') ||
                        (Route::currentRouteName() == 'admin.users.view') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() ==
                            'users.create') || (Route::currentRouteName() == 'admin.users.view') ? 'display: block;' : ''}}">
                        @can('user-create')
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Add new User
                                </p>
                            </a>
                        </li>
                        @endcan

                            @can('user-list')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.view') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    View All Users
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if(Gate::check('role-list') || Gate::check('role-create'))
                <li class="nav-item {{ (Route::currentRouteName() ==
    'roles.index') || (Route::currentRouteName() == 'roles.create') ? 'menu-open menu-is-opening ' : ''}}">
                    <a href="#" class="nav-link {{ (Route::currentRouteName() ==
    'roles.index') || Route::currentRouteName() == 'roles.create' ? 'active' : ''}}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Roles & Permission
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() == 'roles.index') ||
(Route::currentRouteName() == 'roles.create') ? 'display: block;' : ''}}">
                        @can('role-list')
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
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
                </li>
                @endif
                {{-- @can('') --}}
                <li class="nav-item">
                    <a href="{{route('job.show')}}" class="nav-link">
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
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Pay Roll Tracker
                        </p>
                    </a>
                </li>
                {{-- @endcan --}}

                {{--
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            View All Agencies
                        </p>
                    </a>
                </li>
                --}}
                @if(Gate::check('inspector-create') || Gate::check('inspector-list'))
                <li class="nav-item {{ (Route::currentRouteName() ==
'admin.create.addinspector' || Route::currentRouteName() ==
'admin.view.inspector') ? 'menu-open menu-is-opening' : ''}}">
                    <a href="javascript:void(0);" class="nav-link {{ (Route::currentRouteName() ==
    'admin.create.addinspector' || Route::currentRouteName() ==
    'admin.view.inspector')? 'active ' : ''}}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Inspectors
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() ==
    'admin.create.addinspector' || Route::currentRouteName() ==
    'admin.view.inspector' || Route::currentRouteName() ==
    'admin.inspector.message') ? 'display: block;' : ''}}">
                        @can('inspector-create')
                        <li class="nav-item">
                            <a href="{{ route('admin.create.addinspector') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Add new Inspector
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('inspector-list')
                        <li class="nav-item">
                            <a href="{{ route('admin.view.inspector') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    View All Inspectors
                                </p>
                            </a>
                        </li>
                        @endcan

                        {{-- @can('') --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.inspector.message') }}" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>
                                    Inspector Messages
                                </p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                @endif
                <!-- @if(Gate::check('agency-create') || Gate::check('agency-list')) -->
                <li class="nav-item {{ (Route::currentRouteName() == 'admin.agency.agency-register' || Route::currentRouteName() == 'admin.agency.agency-view' || Route::currentRouteName() == 'admin.adminlist.view' || Route::currentRouteName() == 'admin.adminlist.view' || Route::currentRouteName() == 'admin.disapproved.view') ? 'menu-open menu-is-opening' : ''}}">
                    <a href="javascript:void(0);" class="nav-link {{ (Route::currentRouteName() == 'admin.agency.agency-register')? 'active ' : ''}}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Agency
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="{{ (Route::currentRouteName() == 'admin.agency.agency-register') ? 'display: block;' : ''}}">
                        @can('agency-create')
                        <li class="nav-item">
                            <a href="{{ route('admin.agency.agency-register') }}" class="nav-link">
                                <i class="nav-icon fa fa-plus"></i>
                                <p>
                                    Add new Agency
                                </p>
                            </a>
                        </li>
                        @endcan

                        @can('agency-list')
                        <li class="nav-item">
                            <a href="{{ route('admin.agency.agency-view') }}" class="nav-link">
                                <i class="nav-icon  fas fa-building"></i>
                                <p>
                                    View All Agency
                                </p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('admin.adminlist.view') }}" class="nav-link">
                                <i class="nav-icon fas fa-times"></i>
                                <p>
                                    Pending Agencies
                                    <span class="right badge badge-warning">{{ $pendingCount }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.disapproved.view') }}" class="nav-link">
                                <i class="nav-icon fas fa-times"></i>
                                <p>
                                    Disapproved Agencies
                                    <span class="right badge badge-danger">{{ $disapprovedCount }}</span>
                                </p>
                            </a>
                        </li>
                        {{-- @can('') --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.agency.message') }}" class="nav-link">
                                <i class="nav-icon fas fa-comments"></i>
                                <p>
                                    Agency Messages
                                </p>
                            </a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                <!-- @endif -->
                <li class="nav-item">
                    <a href="{{route('mailbox.sent')}}" class="nav-link {{  (Route::currentRouteName() == 'mailbox.sent' || Route::currentRouteName() == 'mailbox.draft' || Route::currentRouteName() == 'mailbox.readmail') ? 'active' : '' }}">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Email Logs
                            <!-- <i class="fas fa-angle-left right"></i> -->
                        </p>
                    </a>
                    <!-- <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../mailbox/mailbox.html" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inbox</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/compose.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Compose</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/read-mail.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Read</p>
                            </a>
                        </li>
                    </ul> -->
                </li>
                <li class="nav-item">
                    <a href="{{route('profile.show')}}" class="nav-link {{  (Route::currentRouteName() == 'profile.show') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Cronfigurations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @can('') --}}
                        <li class="nav-item">
                            <a href="{{route('admin.portal.setup')}}" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Portal Setup
                                </p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{-- @can('') --}}
                        <li class="nav-item">
                            <a href="{{route('admin.portal.mail')}}" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Mail Setup
                                </p>
                            </a>
                        </li>
                        {{-- @endcan --}}

                        {{--
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                        --}}
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
@yield('sidebar')
