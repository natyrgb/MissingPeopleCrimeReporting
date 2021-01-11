<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\MissingPerson;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // returns view of superadmin home
    public function index() {
        return view('superadmin.home', [
            'crime_rates' => Complaint::crime_stat(),
            'type_all' => [
                'Robbery' => Complaint::where('type', 'robbery')->get()->groupBy('status'),
                'Homicide' => Complaint::where('type', 'homicide')->get()->groupBy('status'),
                'Assault' => Complaint::where('type', 'assault')->get()->groupBy('status'),
                'Burglary' => Complaint::where('type', 'burglary')->get()->groupBy('status'),
            ],
            'type_station' => [
                'Robbery' => Complaint::where([
                    ['type', 'robbery'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Homicide' => Complaint::where([
                    ['type', 'homicide'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Assault' => Complaint::where([
                    ['type', 'assault'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Burglary' => Complaint::where([
                    ['type', 'burglary'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
            ],
            'still_missing' => MissingPerson::where('status', 'new')->orWhere('status', 'missing')->count(),
            'found' => MissingPerson::where('status', 'found')->orWhere('status', 'seen')->count(),
        ]);
    }
}
