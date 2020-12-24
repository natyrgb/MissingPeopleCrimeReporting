<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirectToIntended() {
        if(Auth::guard('employee')->user()) {
            if(Auth::guard('employee')->user()->role=='SUPERADMIN'){
                return redirect()->route('superadmin.home');
            }elseif(Auth::guard('employee')->user()->role=='ADMIN'){
                return redirect()->route('admin.home');
            }elseif(Auth::guard('employee')->user()->role=='POLICE'){
                return redirect('/police/home');
            }elseif(Auth::guard('employee')->user()->role=='ATTORNEY'){
                return redirect()->route('attorney.home');
            }
        }else{
            return redirect()->route('employee.login');
        }
    }
    public function index() {
        return view('employee.home');
    }
    public function users() {
        return view('employee.users', ['users' => User::all()]);
    }
    public function complaints() {
        return view('employee.complaints', ['complaints' => Complaint::all()]);
    }
}
