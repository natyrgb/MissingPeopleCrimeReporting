<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Criminal;
use App\Models\WantedCriminal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WantedCriminalsController extends Controller
{
    /**
     * @return view of wanted criminals index with criminals and wanted_criminals objects
     */
    public function index() {
        return view('superadmin.wanted_criminals.index', [
            'wanted_criminals' => WantedCriminal::all(),
            'criminals' => Criminal::all()
        ]);
    }

    public function create() {}

    /**
     * @param App\Models\WantedCriminal object
     * change the status of wanted crimina to found
     * @return redirect back with success message
     */
    public function markFound(WantedCriminal $wantedCriminal) {
        $wantedCriminal->status = 'caught';
        $wantedCriminal->save();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Criminal object
     * create an instance of wanted criminal for the criminal object
     * @return redirect back with success message
     */
    public function makeWanted(Criminal $criminal) {
        $criminal->wanted_criminal()->create();
        return back()->with('success', true);
    }

    public function store(Request $request) {}

    public function show(WantedCriminal $wantedCriminal) {}

    public function edit(WantedCriminal $wantedCriminal) {}

    public function update(Request $request, WantedCriminal $wantedCriminal) {}

    /**
     * @param App\Models\WantedCriminal object
     * delete the wanted criminal entry from database without deleting the criminal
     * @return redirect back with success message
     */
    public function destroy(WantedCriminal $wantedCriminal) {
        $wantedCriminal->delete();
        return back()->with('success', true);
    }
}
