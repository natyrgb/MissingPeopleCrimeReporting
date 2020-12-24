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
    public function index(Request $request) {
        $my_missing = MissingPerson::userMissing($request->user()->id);
        return response()->json(['my_missing' => $my_missing], 200);
    }

    public function foundByUser(Request $request, MissingPerson $missingPerson) {
        $user = $request->user();
        $missingPerson->status = 'found';
        $missingPerson->save();
        return response(['my_missing' => MissingPerson::userMissing($user->id)], 200);
    }

    public function store(Request $request) {
        $user = $request->user();
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png,bmp|max:4000',
            'woreda' => 'required|integer|exists:stations,id',
            'date' => 'required|date'
        ]);
        $missing_person = $user->missingPeople()->create([
            'station_id' => $request['woreda'],
            'name' => $request['name'],
            'description' => $request['description'],
            'time' => $request['date']
        ]);
        if($request->hasFile('image')) {
            $file = $request->file('image');               // you can also use the original name
            $imageName = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('images/missing_people'), $imageName);
            $missing_person->attachment()->create([
                'attachable_id' => $missing_person->id,
                'attachable_type' => 'missing_people',
                'url' => 'images/missing_people/'.$imageName
            ]);
        }
        return response()->json([
            'success' => true,
            'my_missing' => MissingPerson::userMissing($user->id)
        ], 200);
    }

    public function show(MissingPerson $missingPerson) {}

    public function update(Request $request, MissingPerson $missingPerson) { }

    public function destroy(MissingPerson $missingPerson) {}
}
