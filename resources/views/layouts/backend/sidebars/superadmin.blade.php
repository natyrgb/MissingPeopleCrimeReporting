<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="/images/AdminLTELogo.png" alt="MPaCRS" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">MPaCRS</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/images/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block" href="#">{{ Auth::guard('employee')->user()->name }}</a>
            </div>
        </div>

        @php
            $rstations = ['superadmin.stations.create', 'superadmin.stations.index', 'superadmin.stations.edit'];
            $rblogs = ['superadmin.blogs.create', 'superadmin.blogs.index', 'superadmin.blogs.edit'];
            $remployees = ['superadmin.employees.create', 'superadmin.employees.index', 'superadmin.employees.edit'];
            $rcriminal = ['superadmin.wanted_criminals.create', 'superadmin.wanted_criminals.index', 'superadmin.wanted_criminals.edit'];
            $route = Route::currentRouteName();
        @endphp
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('superadmin.home')}}" class="nav-link @if($route == 'superadmin.home') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $rstations)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $rstations)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Stations<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('superadmin.stations.create')}}" class="nav-link @if($route == 'superadmin.stations.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('superadmin.stations.index')}}" class="nav-link @if($route == 'superadmin.stations.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>Show All</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $remployees)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $remployees)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Employees<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('superadmin.employees.create')}}" class="nav-link @if($route == 'superadmin.employees.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('superadmin.employees.index')}}" class="nav-link @if($route == 'superadmin.employees.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>Show All</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $rblogs)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $rblogs)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>News<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('superadmin.blogs.create')}}" class="nav-link @if($route == 'superadmin.blogs.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('superadmin.blogs.index')}}" class="nav-link @if($route == 'superadmin.blogs.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>Show All</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $rcriminal)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $rcriminal)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Wanted Criminal<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('superadmin.wanted_criminals.create')}}" class="nav-link @if($route == 'superadmin.wanted_criminals.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('superadmin.wanted_criminals.index')}}" class="nav-link @if($route == 'superadmin.wanted_criminals.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>Show All</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
