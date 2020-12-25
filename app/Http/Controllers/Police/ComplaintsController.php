<?php

namespace App\Http\Controllers\Police;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Complaint;
use App\Models\Employee;
use App\Models\Finding;
use App\Models\Station;
use App\Models\Suspect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComplaintsController extends Controller
{
    /**
     * @param Illuminate\Http\Request,App\Models\Finding objects
     * validates and create a suspect
     * @return redirect back with success
     */
    public function addSuspect(Request $request, Finding $finding) {
        $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'gender' => [
                'required', 'string',
                Rule::in(['male', 'female'])
            ],
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp|max:3000',
            'description' => 'nullable|string',
            'status' => [
                'required', 'string',
                Rule::in(['wanted', 'in_custody'])
            ]
        ]);
        $finding->suspects()->create($request->except('_token'));
        return back()->with('success', true);
    }

    /**
     * @param suspect_id
     * updates the suspect as in_custody
     * @return redirect back with success
     */
    public function markInCustody($suspect_id) {
        $suspect = Suspect::findOrFail($suspect_id);
        $suspect->status = 'in_custody';
        $suspect->save();
        return back()->with('success', true);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\Finding objects
     * validates and create a attchment file for the finding
     * @return redirect back with success
     */
    public function addFile(Request $request, Finding $finding) {
        $request->validate([
            'url' => 'nullable|mimes:jpg,jpeg,png,bmp,docx,pdf,doc|max:3000'
        ]);
        $attachment = $finding->attachments()->create(['url' => '']);
        $attachment->saveFile($request->file('url'));
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Suspect objects
     * deletes wrongly accused suspect
     * @return redirect back with success
     */
    public function deleteSuspect(Suspect $suspect) {
        $suspect->delete();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Attachment objects
     * deletes wrong file
     * @return redirect back with success
     */
    public function deleteFile(Attachment $attachment) {
        $attachment->delete();
        return back()->with('success', true);
    }

    /**
     * @param App\Models\Finding objects
     * change the status of the complaint to in_court
     * then assign case to the first available attorney or the attorney with least cases
     * @return redirect back with success
     */
    public function sendToCourt(Finding $finding) {
        $station = Auth::guard('employee')->user()->station;
        $attorneys_ava = $station->attorneys()->where('is_available', true);
        $attorneys = $station->attorneys();

        if($attorneys_ava->count()) {
            $attorney = $attorneys_ava->first();
            $finding->attorney_id = $attorney->id;
            $attorney->is_available = false;
            $attorney->save();
            $finding->save();
        }
        else {
            $the_attorney = null;
            $case_count = 10;
            for($i = 0; $i < $attorneys->count(); $i++) {
                if($attorneys[$i]->attorneyCaseCount() < $case_count) {
                    $case_count = $attorneys[$i]->attorneyCaseCount();
                    $the_attorney = $attorneys[$i];
                }
            }
            $finding->attorney_id = $the_attorney->id;
            $the_attorney->is_available = false;
            $the_attorney->save();
            $finding->save();
        }
        $finding->complaint->inCourt();
        $finding->save();
        return back()->with('success', true);
    }
}
