<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\CrimeRecord;
use App\Models\Criminal;
use App\Models\Finding;
use App\Models\Suspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        return view('attorney.home');
    }

    public function cases() {
        $att = Auth::guard('employee')->user();
        return view('attorney.cases', ['findings' => Finding::openCasesForAttorney($att->id)]);
    }

    public function finalize_case(Finding $finding) {
        return view('attorney.finalize_case', ['finding' => $finding]);
    }

    public function give_verdict(Request $request, Finding $finding, Suspect $suspect) {
        $att = Auth::guard('employee')->user();
        if($request->verdict == 'not_guilty') {
            $suspect->verdict = $request->verdict;
            $suspect->save();
            return back();
        }
        else {
            $criminals = Criminal::where('name', 'LIKE', "%$suspect->name%")->get();
            return view('attorney.new_criminal', [
                'suspect' => $suspect,
                'criminals' => $criminals
            ]);
        }
    }

    public function add_to_record(Request $request, Suspect $suspect, Criminal $criminal) {
        $finding_id = $suspect->finding->id;
        $suspect->verdict = 'guilty';
        $suspect->save();
        $criminal->crimeRecords()->create([
            'finding_id' => $finding_id
        ]);
        return redirect()->route('attorney.finalize_case', ['finding' => $suspect->finding]);
    }

    public function new_criminal_record(Request $request, Suspect $suspect) {
        $request->validate([
            'citizen_id' => 'required|string|unique:criminals,citizen_id',
            'name' => 'required|string',
            'age' => 'required|integer|min:10|max:100',
            'address' => 'required|string',
        ]);
    }
}
