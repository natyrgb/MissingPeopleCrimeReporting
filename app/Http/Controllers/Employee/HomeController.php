<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // if not authenticated redirect to login page, else redirect to home page of the employee
    public function redirectToIntended() {
        if(Auth::guard('employee')->user()) {
            $employee = Auth::guard('employee')->user();
            if(!$employee->password_changed)
                return redirect()->route('employee.edit_account');
            else
                return redirect('/'.strtolower($employee->role).'/home');
        }else{
            return redirect()->route('employee.login');
        }
    }
}
