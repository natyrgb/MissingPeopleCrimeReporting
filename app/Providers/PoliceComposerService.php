<?php

namespace App\Providers;

use App\Models\Complaint;
use App\Models\MissingPerson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PoliceComposerService extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('police.*', function($view) {
            $police = Auth::guard('employee')->user();
            $case=$police->policeCase();
            $view->with([
                'case' => $case,
                'has_case' => $case == null ? 'no' : 'yes',
                'new_missing_count' => MissingPerson::newMissingFromStation($police->station_id)->count()
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
