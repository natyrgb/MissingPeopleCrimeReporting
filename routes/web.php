<?php

use App\Http\Controllers\Admin\ComplaintsController;
use App\Http\Controllers\Admin\EmployeesController as AdminEmployeesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MissingPeopleController;
use App\Http\Controllers\Attorney\HomeController as AttorneyHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\HomeController as EmployeeHomeController;
use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\Police\ComplaintsController as PoliceComplaintsController;
use App\Http\Controllers\Police\HomeController as PoliceHomeController;
use App\Http\Controllers\Police\MissingPeopleController as PoliceMissingPeopleController;
use App\Http\Controllers\SuperAdmin\BlogsController;
use App\Http\Controllers\SuperAdmin\EmployeesController;
use App\Http\Controllers\SuperAdmin\StationsController;
use App\Http\Controllers\SuperAdmin\WantedCriminalsController;
use App\Http\Controllers\SuperAdmin\HomeController as SuperAdminHomeController;

Route::get('/', [EmployeeHomeController::class, 'redirectToIntended']);

Auth::routes();
Route::get('/employee/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
Route::post('/employee/login', [EmployeeLoginController::class, 'login'])->name('employee.login.post');
Route::post('/employee/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');

Route::prefix('superadmin')->name('superadmin.')->middleware(['auth:employee', 'superadmin'])->group(function() {
    Route::get('home', [SuperAdminHomeController::class, 'index'])->name('home');
    Route::resource('stations', StationsController::class);
    Route::get('add_admin/{station}/{employee}', [StationsController::class, 'add_admin'])->name('add_admin');
    Route::get('get_polices/{station}', [StationsController::class, 'get_polices'])->name('get_polices');
    Route::resource('employees', EmployeesController::class);
    Route::resource('blogs', BlogsController::class);
    Route::resource('wanted_criminals', WantedCriminalsController::class);
    Route::get('wanted_criminals/mark_found/{wantedCriminal}', [WantedCriminalsController::class, 'markFound'])->name('wanted_criminals.mark_found');
    Route::get('make_wanted/{criminal}', [WantedCriminalsController::class, 'makeWanted'])->name('make_wanted');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:employee', 'admin'])->group(function() {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('complaints/new', [ComplaintsController::class, 'newComplaints'])->name('complaints.new');
    Route::get('complaints/get_police/{department_name}', [ComplaintsController::class, 'findAvailablePolice'])->name('complaints.get_police');
    Route::get('complaints/assign_case/{complaint}/{police}', [ComplaintsController::class, 'assignCase'])->name('complaints.assing_case');
    Route::resource('complaints', ComplaintsController::class)->only(['index', 'destroy']);

    Route::get('/missing_people/new', [MissingPeopleController::class, 'newMissing'])->name('missing_people.new');
    Route::get('mark_as_found/{missing_id}', [MissingPeopleController::class, 'mark_found'])->name('mark_as_found');
    Route::resource('missing_people', MissingPeopleController::class)->only(['index', 'destroy']);
    Route::resource('employees', AdminEmployeesController::class);
    Route::resource('blogs', BlogsController::class);
    Route::resource('wanted_criminals', WantedCriminalsController::class);
});

Route::prefix('police')->name('police.')->middleware(['auth:employee', 'police'])->group(function() {
    Route::get('home', [PoliceHomeController::class, 'index'])->name('home');
    Route::get('/new_missing_people', [PoliceHomeController::class, 'newMissing'])->name('new_missing');
    Route::get('mark_as_found/{missing_id}', [PoliceHomeController::class, 'markFound'])->name('mark_as_found');

    Route::get('current_case', [PoliceHomeController::class, 'current_case'])->name('current_case');
    Route::post('add_suspect/{finding}', [PoliceComplaintsController::class, 'add_suspect'])->name('add_suspect');
    Route::get('mark_in_custody/{suspect}', [PoliceComplaintsController::class, 'markInCustody'])->name('mark_in_custody');
    Route::delete('delete_suspect/{suspect}', [PoliceComplaintsController::class, 'delete_suspect'])->name('delete_suspect');
    Route::post('add_file/{finding}', [PoliceComplaintsController::class, 'add_file'])->name('add_file');
    Route::delete('delete_file/{attachment}', [PoliceComplaintsController::class, 'delete_file'])->name('delete_file');
    Route::get('send_to_court/{finding}', [PoliceComplaintsController::class, 'send_to_court'])->name('send_to_court');
});

Route::prefix('attorney')->name('attorney.')->middleware('attorney')->group(function() {
    Route::get('home', [AttorneyHomeController::class, 'index'])->name('home');
    Route::get('cases', [AttorneyHomeController::class, 'cases'])->name('cases');
    Route::get('finalize_case/{finding}', [AttorneyHomeController::class, 'finalize_case'])->name('finalize_case');
    Route::put('give_verdict/{finding}/{suspect}', [AttorneyHomeController::class, 'give_verdict'])->name('give_verdict');
    Route::get('add_to_record/{suspect}/{criminal}', [AttorneyHomeController::class, 'add_to_record'])->name('add_to_record');
    Route::post('new_criminal_record/{suspect}', [AttorneyHomeController::class, 'new_criminal_record'])->name('new_criminal_record');
});
