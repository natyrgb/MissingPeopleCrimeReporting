<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Finding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintsController extends Controller
{
    /**
     * @return view of complaints index with object of all complaints made to the station managed by the admin
     */
    public function index() {
        $admin = Auth::guard('employee')->user();
        return view('admin.complaints.index', [
            'complaints' => Complaint::where('station_id', $admin->station_id)->get()->groupBy('type'),
            'available_police' => Employee::availablePolice($admin->station_id)
        ]);
    }

    /**
     * @return view of complaints index with object of new complaints made to the station managed by the admin
     */
    public function newComplaints() {
        $admin = Auth::guard('employee')->user();
        return view('admin.complaints.new', [
            'complaints' => Complaint::newComplaints($admin->station_id)->groupBy('type'),
        ]);
    }

    /**
     * @param department_name
     * @return json object of available polices of that department
     */
    public function findAvailablePolice($department_name) {
        $department_id = Department::where([
            ['name', $department_name],
            ['station_id', Auth::guard('employee')->user()->station_id]
        ])->firstOrFail()->id;
        $employees = Employee::where([
            ['role', 'POLICE'],
            ['department_id', $department_id],
            ['is_available', true]
        ])->get();
        return response()->json([
            $employees
        ], 200);
    }

    /**
     * @param complaint_id,police_id
     * assigns the complaint to the police
     * @return redirect
     */
    public function assignCase($complaint_id, $police_id) {
        $complaint = Complaint::findOrFail($complaint_id);
        $police = Employee::findOrFail($police_id);
        $complaint->police_id = $police->id;
        $complaint->status = 'under_investigation';
        $police->is_available = false;
        $complaint->save();
        $police->save();
        $complaint->finding()->create();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Complaint object
     * deletes the reported complaint
     * @return redirect to view of employees index with success
     */
    public function destroy(Complaint $complaint) {
        $complaint->delete();
        return back()->with('success', true);
    }
}
