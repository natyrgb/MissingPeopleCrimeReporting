<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComplaintsController extends Controller
{
    public function index(Request $request) {
        $my_complaints = Complaint::where('user_id', $request->user()->id)->get();
        return response()->json(['my_complaints' => $my_complaints], 200);
    }

    public function store(Request $request) {
        $crime = ['robbery', 'homicide', 'domestic_abuse', 'assault', 'burglary', 'narcotics', 'sex_crime', 'other'];
        $validator = Validator::make($request->all(), [
            'type' => [
                'required',
                Rule::in($crime)
            ],
            'details' => 'required|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,bmp|max:4000',
            'station_id' => 'required|integer|exists:stations,id'
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        $user = $request->user();
        $complaint = $user->complaints()->create([
            'station_id' => $request['station_id'],
            'woreda' => $request['woreda'],
            'type' => $request['type'],
            'details' => $request['details']
        ]);
        if($request->hasFile('image')) {
            $file = $request->file('image');               // you can also use the original name
            $imageName = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('images/complaints'), $imageName);
            $complaint->attachment()->create([
                'attachable_id' => $complaint->id,
                'attachable_type' => 'complaints',
                'url' => 'images/complaints/'.$imageName
            ]);
        }
        $my_complaints = Complaint::where('user_id', $request->user()->id)->get();
        return response()->json([
            'success' => true,
            'my_complaints' => $my_complaints
        ], 200);
    }

    public function show(Complaint $complaint) {
        return response()->json(['complaint' => $complaint], 200);
    }

    public function update(Request $request, Complaint $complaint) {}

    public function destroy(Request $request, Complaint $complaint) {}
}
