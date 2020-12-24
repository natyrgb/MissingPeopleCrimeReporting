<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\MissingPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function myComplaints(Request $request) {
        $my_complaints = Complaint::where('user_id', $request->user()->id)->get();
        return response()->json(['my_complaints' => $my_complaints], 200);
    }

    public function myMissing() {
        $my_missing = MissingPerson::userMissing(Auth::user()->id);
        return response()->json(['my_missing' => $my_missing], 200);
    }
}
