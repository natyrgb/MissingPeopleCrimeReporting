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
    /**
     * @param Illuminate\Http\Request object
     * @return json object of complaints made by the user
     */
    public function index(Request $request) {
        $my_complaints = Complaint::where('user_id', $request->user()->id)->get();
        return response()->json(['my_complaints' => $my_complaints], 200);
    }

    /**
     * @param Illuminate\Http\Request object
     * validates the input and create complaints entry
     * @return json object of complaints made by the user and success message
     */
    public function store(Request $request) {
        $crime = ['robbery', 'homicide', 'assault', 'burglary', 'other'];
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
        $complaint = $user->complaints()->create($request->all());
        if($request->hasFile('image')) {
            $attachment = $complaint->attachment()->create([
                'attachable_id' => $complaint->id,
                'attachable_type' => 'complaints',
                'url' => 'images/complaints/'
            ]);
            $attachment->saveFile($request->file('image'));
        }
        $my_complaints = Complaint::where('user_id', $request->user()->id)->get();
        return response()->json([
            'success' => true,
            'my_complaints' => $my_complaints
        ], 200);
    }
}
