<?php

namespace App\Http\Controllers\Police;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
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
        return view('police.home');
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
