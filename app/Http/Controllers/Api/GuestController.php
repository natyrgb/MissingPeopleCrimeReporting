<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\MissingPerson;
use App\Models\Station;
use App\Models\WantedCriminal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * @return json paginated object of missing people which are not found
     */
    public function getWoredas() {
        $woredas = Station::where('id', '<>', 1)->get()->groupBy('woreda');
        return response()->json($woredas);
    }

    /**
     * @return json paginated object of missing people which are not found
     */
    public function missingPeople() {
        return response()->json(['missing_people' => MissingPerson::where([
            ['status', '<>', 'found'],
            ['status', '<>', 'seen']
        ])->paginate(6)]);
    }

    /**
     * @return json paginated object of wanted criminals
     */
    public function wantedCriminals() {
        return response()->json(['wanted_criminals' => WantedCriminal::paginate(3)]);
    }

    /**
     * @return json object of blogs with size of 3
     */
    public function newsFeed() {
        return response()->json(['news' => Blog::thisWeeksNews()]);
    }
}
