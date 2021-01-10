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
        if(!$criminal->wanted_criminal()->count()) {
            if($criminal->wanted_criminal->status != 'wanted') {
                $criminal->wanted_criminal()->create();
                event(new \App\Events\WantedCriminalAdded());
                return back()->with('success', true);
            }
            return back()->with('error', true);
        }
        return back()->with('error', true);
    }

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
