<aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
        <h5>{{ Auth::guard('employee')->user()->name }}</h5>
        <a class="d-block" href="javascript:{}" onclick="document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
