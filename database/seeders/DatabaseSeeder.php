<?php

namespace Database\Seeders;

use App\Models\Criminal;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 1; $i <=6; $i++) {
            Station::create([
                'woreda' => $i,
                'name' => $faker->streetName
            ]);
        }

        $stations = Station::all();
        $departments = ['robbery', 'homicide', 'assault', 'burglary', 'narcotics'];
        foreach ($stations as $station) {
            if($station->id != 1) {
                foreach ($departments as $department) {
                    Department::create([
                        'station_id' => $station->id,
                        'name' => $department
                    ]);
                }
            }
        }

        $deps = Department::all();
        $roles = ['POLICE', 'ATTORNEY'];
        Employee::create([
            'employee_id' => 'super',
            'name' => $faker->name,
            'role' => 'SUPERADMIN',
            'station_id' => 1,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => Hash::make('secret'),
            'is_available' => true
        ]);
        foreach ($deps as $dep) {
            for($i = 1; $i <= 3; $i++) {
                $role = $roles[random_int(0, 1)];
                Employee::create([
                    'employee_id' => substr($role, 0, 3) . $faker->randomNumber(6, true),
                    'name' => $faker->name,
                    'department_id' => $role=='POLICE' ? $dep->id : null,
                    'station_id' => $dep->station->id,
                    'role' => $role,
                    'email' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'password' => Hash::make('secret'),
                    'is_available' => true
                ]);
            }
        }
        for($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('secret'),
                'woreda' => $i
            ]);
        }
        Criminal::create([
            'citizen_id' => $faker->bankAccountNumber,
            'name' => $faker->name,
            'birthdate' => $faker->date('Y-m-d', '2002-01-01'),
            'gender' => 'male',
            'address' => $faker->address,
            'occupation' => 'unemployed',
            'mugshot1' => $faker->image(public_path('images/criminals'))
        ]);
    }
}
