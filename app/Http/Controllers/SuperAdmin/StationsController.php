<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StationsController extends Controller
{
    /**
     * @return view of stations index with all stations
     */
    public function index() {
        return view('superadmin.stations.index', ['stations' => Station::where('id', '<>', 1)->get()]);
    }

    /**
     * @return redirect to view to create station
     */
    public function create() {
        return view('superadmin.stations.create');
    }

    /**
     * @param Illuminate\Http\Request object
     * validate the inputs and create a station
     * @return redirect to view of stations index with success message
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|unique:stations,name',
            'woreda' => 'required|integer|between:1,30'
        ]);
        $station = Station::create($request->all());
        $departments = ['robbery', 'homicide', 'assault', 'burglary', 'narcotics'];
        foreach($departments as $d) {
            $station->departments()->create([
                'name' => $d
            ]);
        }
        return redirect()->route('superadmin.stations.index')
        ->with('success', true);
    }

    public function show(Station $station) {}

    /**
     * @param App\Models\Station object
     * @return view to edit the given station
     */
    public function edit(Station $station) {
        return view('superadmin.stations.edit', ['station' => $station]);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Station objects
     * validate the inputs and updates the given station
     * @return redirect to view of stations index with success message
     */
    public function update(Request $request, Station $station) {
        $request->validate([
            'name' => [
                'required','string',
                Rule::unique('stations')->ignore($station)
            ],
            'woreda' => 'required|integer|between:1,6'
        ]);
        $station->name = $request['name'];
        $station->woreda = $request['woreda'];
        $station->save();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Station objects
     * deletes the given station and all associated departments and employees
     * @return redirect to view of stations index with success message
     */
    public function destroy(Station $station) {
        $station->admin_id = null;
        $station->save();
        $station->delete();
        return redirect()->route('superadmin.stations.index')
        ->with('success', true);
    }

    /**
     * @param station_id objects
     * @return json object of polices in the station with the given station_id
     */
    public function getPolices($station_id) {
        $employees = Employee::where([
            ['role', 'POLICE'],
            ['station_id', $station_id]
        ])->get();
        return response()->json($employees, 200);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Station,App\Models\Employee objects
     * if there was another admin, change the previous admin to police and make availability true
     * change the station admin_id to the new employee id
     * @return redirect back with success message
     */
    public function addAdmin(Request $request, Station $station, Employee $employee)
    {
        if($station->admin != null) {
            $station->admin->role = 'POLICE';
            $station->admin->is_available = true;
            $station->admin->save();
        }
        $station->admin_id = $employee->id;
        $employee->role = 'ADMIN';
        $employee->is_available = null;
        $employee->save();
        $station->save();
        return back()->with('success', true);
    }
}
