<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Complaint;
use App\Models\MissingPerson;
use App\Models\Station;
use App\Models\User;
use App\Models\WantedCriminal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function charts($userId = 0) {
        $user = User::where('id', $userId)->first();
        $data = [
            'crime_rates' => Complaint::crime_stat(),
            'still_missing' => MissingPerson::where('status', 'new')->orWhere('status', 'missing')->count(),
            'found' => MissingPerson::where('status', 'found')->orWhere('status', 'seen')->count(),
        ];
        return response()->json($data, 200);
    }
}
