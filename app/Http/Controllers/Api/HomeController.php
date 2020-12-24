<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getWoredas() {
        $woredas = Station::all()->groupBy('woreda');
        return response()->json($woredas);
    }
    public function my_complaints()
    {
        //
    }
}
