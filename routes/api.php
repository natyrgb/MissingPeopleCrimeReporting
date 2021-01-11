<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ComplaintsController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\MissingPeopleController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/get_woredas', [GuestController::class, 'getWoredas']);
    Route::get('/charts_api/{userId?}', [GuestController::class, 'charts']);
    Route::get('/missing_people_for_guest', [GuestController::class, 'missingPeople']);
    Route::get('/wanted_criminals_api', [GuestController::class, 'wantedCriminals']);
    Route::get('/news_feed_api', [GuestController::class, 'newsFeed']);

    Route::middleware('auth:api')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/mark_missing_found/{missingPerson}', [MissingPeopleController::class, 'foundByUser']);
        Route::apiResource('complaints_api', ComplaintsController::class)->except(['show','update','destroy']);
        Route::apiResource('missings_api', MissingPeopleController::class)->except(['show','update','destroy']);
    });
});


Route::any('{slug}', function(){
    return view ('welcome');
});
