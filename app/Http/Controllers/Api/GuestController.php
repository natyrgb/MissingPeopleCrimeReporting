<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Complaint;
use App\Models\MissingPerson;
use App\Models\Station;
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

    public function charts(Request $request)
    {
        $data = [
            'crime_rates' => Complaint::crime_stat(),
            'type_all' => [
                'Robbery' => Complaint::where('type', 'robbery')->get()->groupBy('status'),
                'Homicide' => Complaint::where('type', 'homicide')->get()->groupBy('status'),
                'Assault' => Complaint::where('type', 'assault')->get()->groupBy('status'),
                'Burglary' => Complaint::where('type', 'burglary')->get()->groupBy('status'),
            ],
            'still_missing' => MissingPerson::where('status', 'new')->orWhere('status', 'missing')->count(),
            'found' => MissingPerson::where('status', 'found')->orWhere('status', 'seen')->count(),
        ];
        if($request->user()) {
            $data['type_station'] = [
                'Robbery' => Complaint::where([
                    ['type', 'robbery'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Homicide' => Complaint::where([
                    ['type', 'homicide'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Assault' => Complaint::where([
                    ['type', 'assault'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
                'Burglary' => Complaint::where([
                    ['type', 'burglary'],
                    ['station_id', Auth::guard('employee')->user()->station_id]
                ])->get()->groupBy('status'),
            ];
        }
        return response()->json($data, 200);
    }
}
