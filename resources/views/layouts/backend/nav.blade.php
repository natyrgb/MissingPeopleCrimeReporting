<nav class="main-header navbar navbar-expand navbar-dark navbar-gray-dark border-bottom-0">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
              <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-5" style="left: inherit; right: 0px;">
                <span class="dropdown-item dropdown-header">{{ Auth::guard('employee')->user()->email }}</span>
                <div class="dropdown-divider"></div>
                <a href="{{route('employee.edit_account')}}" class="dropdown-item">
                    <i class="fas fa-edit mr-2"></i> Edit Account
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
          </li>

    </ul>

</nav>
