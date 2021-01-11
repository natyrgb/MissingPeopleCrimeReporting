<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\MissingPerson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissingPeopleController extends Controller
{
    /**
     * @param Illuminate\Http\Request object
     * @return json object of missing people reported by the user
     */
    public function index(Request $request) {
        $my_missing = MissingPerson::userMissing($request->user()->id);
        return response()->json(['my_missing' => $my_missing], 200);
    }

    /**
     * @param Illuminate\Http\Request,App\Models\MissingPerson object
     * updates the missingPerson object as seen
     * @return json object of missing people reported by the user and success message
     */
    public function foundByUser(Request $request, MissingPerson $missingPerson) {
        $user = $request->user();
        $missingPerson->status = 'seen';
        $missingPerson->save();
        return response([
            'my_missing' => MissingPerson::userMissing($user->id),
            'success' => true
        ], 200);
    }

    /**
     * @param Illuminate\Http\Request object
     * validates the input and create missing_person entry
     * @return json object of complaints made by the user and success message
     */
    public function store(Request $request) {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png,bmp|max:4000',
            'woreda' => 'required|integer|exists:stations,id',
            'date' => 'required|date'
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Your input was invalid.'
            ], 422);
        }
        $request['time'] = $request['date'];
        $missing_person = $user->missingPeople()->create($request->all());
        if($request->hasFile('image')) {
            $attachment = $missing_person->attachment()->create([
                'attachable_id' => $missing_person->id,
                'attachable_type' => 'missing_people',
                'url' => ''
            ]);
            $attachment->saveFile($request->file('image'));
        }
        event(new \App\Events\MissingPersonAdded());
        return response()->json([
            'success' => true,
            'my_missing' => MissingPerson::userMissing($user->id)
        ], 200);
    }
}
