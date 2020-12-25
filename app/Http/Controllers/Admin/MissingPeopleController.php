<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\MissingPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MissingPeopleController extends Controller
{
    /**
     * @return redirect to view of missing people index with array of all missing people and available polices
     */
    public function index() {
        $admin = Auth::guard('employee')->user();
        return view('admin.missing_people.index', [
            'missing_people' => MissingPerson::where('woreda', $admin->station->woreda)->get(),
            'available_police' => Employee::availablePolice($admin->station_id)
        ]);
    }

    /**
     * @return redirect to view of new missing people with array of newly reported missing people and available polices
     */
    public function newMissing() {
        $admin = Auth::guard('employee')->user();
        return view('admin.missing_people.new', [
            'missing_people' => MissingPerson::newMissingFromStation($admin->station_id),
            'available_police' => Employee::availablePolice($admin->station_id)
        ]);
    }

    /**
     * @param Illuminate\Http\Request,$missing_id object
     * check if the sent missing_person id exists and assign the
     * @return redirect to view of employees index with success
     */
    public function markFound($missing_id) {
        $missing = MissingPerson::findOrFail($missing_id);
        $missing->status = 'found';
        $missing->save();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\MissingPerson object
     * deletes the reported missing person
     * @return redirect to view of employees index with success
     */
    public function destroy(MissingPerson $missingPerson) {
        $missingPerson->delete();
        return back()->with('success', true);
    }
}
