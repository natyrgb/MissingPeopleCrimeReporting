<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends Controller
{

    use AuthenticatesUsers;

    public function __construct() {
      $this->middleware('guest')->except('logout');
    }

    public function guard() {
     return Auth::guard('employee');
    }

    public function showLoginForm() {
        return view('auth.emp_login');
    }
    protected function redirectTo() {
        if(Auth::guard('employee')->user()->role=='SUPERADMIN'){
            return '/superadmin/home';
        }elseif(Auth::guard('employee')->user()->role=='ADMIN'){
            return '/admin/home';
        }elseif(Auth::guard('employee')->user()->role=='POLICE'){
            return '/police/home';
        }elseif(Auth::guard('employee')->user()->role=='ATTORNEY'){
            return '/attorney/home';
        }
    }
}
