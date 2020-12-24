<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\MissingPerson;
use App\Models\WantedCriminal;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index() {
        return response()->json(['news' => Blog::all()]);
    }

    public function missingPeople() {
        return response()->json(['missing_people' => MissingPerson::where('status', '<>', 'found')->paginate(1)]);
    }

    public function wantedCriminals() {
        return response()->json(['wanted_criminals' => WantedCriminal::paginate(1)]);
    }

    public function newsFeed() {
        return response()->json(['news' => Blog::orderBy('created_at', 'desc')->take(3)->get()]);
    }
}
