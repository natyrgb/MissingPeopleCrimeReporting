<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // returns view of superadmin home
    public function index() {
        return view('superadmin.home');
    }
}
