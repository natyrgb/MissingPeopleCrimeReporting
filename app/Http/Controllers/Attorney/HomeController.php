<?php

namespace App\Http\Controllers\Attorney;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\CrimeRecord;
use App\Models\Criminal;
use App\Models\Finding;
use App\Models\MissingPerson;
use App\Models\Suspect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    /**
     * @return view of attorney home
     */
    public function index() {
        return view('attorney.home', [
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
     * @return view of attorney open cases with open cases object
     */
    public function openCases() {
        $att = Auth::guard('employee')->user();
        return view('attorney.cases', ['findings' => Finding::openCasesForAttorney($att->id)]);
    }

    /**
     * @return view of attorney closed cases with closed cases object
     */
    public function closedCases() {
        $att = Auth::guard('employee')->user();
        return view('attorney.closed_cases', ['findings' => Finding::closedCasesForAttorney($att->id)]);
    }

    /**
     * @param App\Models\Finding object
     * @return view of finalize case with the finding object
     */
    public function finalizeCase(Finding $finding) {
        return view('attorney.finalize_case', ['finding' => $finding]);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Finding,App\Models\Suspect,$verdict object
     * if verdict is not guilty
     * save verdict of the suspect
     * @return back
     * if verdict is guilty
     * save verdict of the suspect
     * @return view of new criminal with the suspect and criminals with similar name
     */
    public function giveVerdict(Suspect $suspect, $verdict) {
        $suspect->verdict = $verdict;
        $suspect->save();
        if($verdict == 'not_guilty') {
            return back()->with('success', true);
        }
        else {
            $criminals = Criminal::where('name', 'LIKE', "%$suspect->name%")->get();
            return view('attorney.new_criminal', [
                'suspect' => $suspect,
                'criminals' => $criminals
            ]);
        }
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Finding,App\Models\Criminal object
     * change the verdict of suspect to guilty and add crime record to the existing criminal's record
     * @return redirect to finalize case with the finding object
     */
    public function addToRecord(Request $request, Suspect $suspect, Criminal $criminal) {
        $finding_id = $suspect->finding->id;
        $criminal->crimeRecords()->create([
            'finding_id' => $finding_id
        ]);
        return redirect()->route('attorney.finalize_case', ['finding' => $suspect->finding])->with('success', true);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Finding,App\Models\Suspect object
     * validates the input and redirect back with errors if there are validation errors
     * creates crimin
     * @return redirect to finalize case with the finding object
     */
    public function newCriminalRecord(Request $request, Finding $finding, Suspect $suspect) {
        $request->validate([
            'citizen_id' => 'required|string|unique:criminals,citizen_id',
            'name' => 'required|string',
            'birthdate' => [
                'required', 'date',
                function($attribute, $value, $fail) {
                    $now = Carbon::today()->year;
                    $diff = $now-explode('-', $value)[0];
                    if($diff < 18) {
                        $fail('Age is less than 18 is invalid.');
                    }
                }
            ],
            'address' => 'required|string',
            'gender' => [
                'required', 'string',
                Rule::in(['male', 'female'])
            ],
            'occupation' => [
                'required', 'string',
                Rule::in(['employed', 'unemployed'])
            ],
            'mugshot1' => 'required|file|image|mimes:jpg,png|max:4000',
            'mugshot2' => 'required|file|image|mimes:jpg,png|max:4000'
        ]);
        $criminal = Criminal::create($request->except('_token'));

        $criminal->saveFile($request->file('mugshot1'), 'mugshot1');
        $criminal->saveFile($request->file('mugshot2'), 'mugshot2');
        CrimeRecord::create([
            'criminal_id' => $criminal->id,
            'finding_id' => $finding->id
        ]);
        return redirect()->route('attorney.finalize_case', ['finding' => $finding])->with('success', true);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Finding object
     * if there are suspects with no verdict redirect back with error
     * else change status of complaint to solved and make attorney available
     * @return redirect to attorney home with success
     */
    public function closeCase(Request $request, Finding $finding) {
        $attorney = Auth::guard('employee')->user();
        if($finding->suspects()->where('verdict', 'under_investigation')->count())
            return back()->with('error', true)->with('message', 'There are suspects not given verdict.');
        $complaint = $finding->complaint;
        $complaint->status = 'solved';
        $complaint->save();
        $open_cases = Finding::openCasesForAttorney($attorney->id)->count();
        if(!$open_cases)
            $attorney->is_available = true;
        $attorney->save();
        return redirect()->route('attorney.home')->with('success', true);
    }
}
