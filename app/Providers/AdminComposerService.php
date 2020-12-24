<?php

namespace App\Providers;

use App\Models\Complaint;
use App\Models\MissingPerson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminComposerService extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('admin.*', function ($view) {
            $station = Auth::guard('employee')->user()->station_id;
            $view->with([
                'new_missing_count' => MissingPerson::newMissingFromStation($station)->count(),
                'new_complaints_count' => Complaint::newComplaints($station)->count()
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
