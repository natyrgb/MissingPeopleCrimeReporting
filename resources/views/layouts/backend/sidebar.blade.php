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

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('employee.home')}}" class="nav-link @if(Route::currentRouteName() == 'employee.home') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>
                @if(Auth::guard('employee')->user()->role == 'ADMIN')
                    <li class="nav-item">
                        <a href="{{route('employee.users')}}" class="nav-link @if(Route::currentRouteName() == 'employee.users') active @endif">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Users</p>
                        </a>
                    </li>
                @endif
                @if(Auth::guard('employee')->user()->role == 'POLICE')
                <li class="nav-item">
                    <a href="{{route('employee.complaints')}}" class="nav-link @if(Route::currentRouteName() == 'employee.complaints') active @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Complaints</p>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>
