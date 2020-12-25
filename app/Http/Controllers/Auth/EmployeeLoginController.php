<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends Controller
{

    use AuthenticatesUsers;

    // constructs the controller with the guest middleware
    public function __construct() {
      $this->middleware('guest')->except('logout');
    }

    // specify that the guard is employee, since we are using employees table instead of users table
    public function guard() {
     return Auth::guard('employee');
    }

    //returns view of employee login
    public function showLoginForm() {
        return view('auth.emp_login');
    }

    // override the redirectTo method to return appropriate url
    protected function redirectTo() {
        $employee = Auth::guard('employee')->user();
        if(!$employee->password_changed) {
            return '/employee/edit_account';
        }
        else
        return redirect('/'.strtolower($employee->role).'/home');
    }
}
