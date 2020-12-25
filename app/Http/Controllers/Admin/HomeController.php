<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // returns view of admin home
    public function index() {
        return view('admin.home');
    }
}
