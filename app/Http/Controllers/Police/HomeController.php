<?php

namespace App\Http\Controllers\Police;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\MissingPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        return view('police.home');
    }

    public function current_case() {
        return view('police.current_complaint');
    }

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
}
