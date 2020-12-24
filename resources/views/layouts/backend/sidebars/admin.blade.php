
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
            $rcomplaints = ['admin.complaints.index', 'admin.complaints.new'];
            $rmissing = ['admin.missing_people.index', 'admin.missing_people.new'];
            $remployees = ['admin.employees.create', 'admin.employees.index', 'admin.employees.edit'];
            $route = Route::currentRouteName();
        @endphp
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.home')}}" class="nav-link @if($route == 'admin.home') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $rmissing)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $rmissing)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Missing People
                            <span class="right badge badge-success">{{$new_missing_count}}</span>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.missing_people.new')}}" class="nav-link @if($route == 'admin.missing_people.new') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>New Missing People</p>
                                <span class="right badge badge-success">{{$new_missing_count}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.missing_people.index')}}" class="nav-link @if($route == 'admin.missing_people.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>All Missing People</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview @if(in_array($route, $rcomplaints)) menu-open @endif">
                    <a href="#" class="nav-link @if(in_array($route, $rcomplaints)) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Complaints
                            <span class="right badge badge-success">{{$new_complaints_count}}</span>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.complaints.new')}}" class="nav-link @if($route == 'admin.complaints.new') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>New Complaints</p>
                                <span class="right badge badge-success">{{$new_complaints_count}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.complaints.index')}}" class="nav-link @if($route == 'admin.complaints.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>All Complaints</p>
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
                            <a href="{{route('admin.employees.create')}}" class="nav-link @if($route == 'admin.employees.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i><p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.employees.index')}}" class="nav-link @if($route == 'admin.employees.index') active @endif">
                                <i class="far fa-eye nav-icon"></i><p>Show All</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
