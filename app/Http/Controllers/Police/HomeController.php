<?php

namespace App\Http\Controllers\Police;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Criminal;
use App\Models\MissingPerson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @return view of police home
     */
    public function index() {
        return view('police.home', [
            'crime_rates' => Complaint::crime_stat(),'type_all' => [
                'Robbery' => Complaint::where('type', 'robbery')->get()->groupBy('status'),
                'Homicide' => Complaint::where('type', 'homicide')->get()->groupBy('status'),
                'Assault' => Complaint::where('type', 'assault')->get()->groupBy('status'),
                'Burglary' => Complaint::where('type', 'burglary')->get()->groupBy('status'),
            ],
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

    /**
     * @return view of police current case
     */
    public function currentCase() {
        return view('police.current_complaint');
    }

    /**
     * @param missing_id
     * updates the missing person identified by missing_id and updates to found
     * @return redirect back with success
     */
    public function markFound($missing_id) {
        $missing = MissingPerson::findOrFail($missing_id);
        $missing->status = 'found';
        $missing->save();
        return back()->with('success', true);
    }

    /**
     * @return redirect to view of new missing people with array of newly reported missing people and available polices
     */
    public function newMissing() {
        $police = Auth::guard('employee')->user();
        return view('police.new_missing', [
            'missing_people' => MissingPerson::newMissingFromStation($police->station_id)
        ]);
    }

    /**
     * @param user
     * updates the missing person identified by missing_id and updates to found
     * @return redirect back with success
     */
    public function reportSpam(Complaint $complaint) {
        $complaint->reportSpam();
        return redirect('/police/home')->with('success', true);
    }
}
