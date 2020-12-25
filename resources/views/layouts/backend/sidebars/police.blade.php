
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
                    <a href="{{route('police.home')}}" class="nav-link @if(Route::currentRouteName() == 'police.home') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('police.current_case')}}" class="nav-link @if(Route::currentRouteName() == 'police.current_case') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Current Case</p>
                        <span class="right badge badge-success">{{$has_case}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('police.new_missing')}}" class="nav-link @if(Route::currentRouteName() == 'police.new_missing') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Missing People</p>
                        <span class="right badge badge-success">{{$new_missing_count}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('employee.edit_account')}}" class="nav-link @if(Route::currentRouteName() == 'employee.edit_account') active @endif">
                        <i class="far fa-eye nav-icon"></i><p>Edit Account</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
