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
    public function add_suspect(Request $request, Finding $finding) {
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
        $finding->suspects()->create($request->except('token'));
        return back()->with('success', true);
    }

    public function markInCustody($suspect_id) {
        $suspect = Suspect::findOrFail($suspect_id);
        $suspect->status = 'in_custody';
        $suspect->save();
        return back()->with('success', true);
    }

    public function add_file(Request $request, Finding $finding) {
        $request->validate([
            'url' => 'nullable|mimes:jpg,jpeg,png,bmp,docx,pdf,doc|max:3000'
        ]);
        $file = $request->file('url');               // you can also use the original name
        $imageName = time().'-'.$file->getClientOriginalName();
        $file->move(public_path('images/findings'), $imageName);
        $finding->attachments()->create(['url' => 'images/findings/'.$imageName]);
        return back()->with('success', true);
    }

    public function delete_suspect(Suspect $suspect) {
        $suspect->delete();
        return back()->with('success', true);
    }

    public function delete_file(Attachment $attachment) {
        $attachment->delete();
        return back()->with('success', true);
    }

    public function send_to_court(Request $request, Finding $finding) {
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
        $finding->complaint->status = 'in_court';
        $finding->complaint->police->is_available = true;
        $finding->complaint->police->save();
        $finding->complaint->save();
        $finding->save();
        return back()->with('success', true);
    }
}
