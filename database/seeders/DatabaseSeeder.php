<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Complaint;
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

        $stations = Station::all();
        $departments = ['robbery', 'homicide', 'assault', 'burglary', 'others'];
        foreach ($stations as $station) {
            if($station->id != 1) {
                foreach ($departments as $department) {
                    $dep = Department::create([
                        'station_id' => $station->id,
                        'name' => $department
                    ]);
                    for($i = 1; $i <= 2; $i++) {
                        Employee::create([
                            'employee_id' => 'POL' . $faker->randomNumber(6, true),
                            'name' => $faker->name,
                            'department_id' => $dep->id,
                            'station_id' => $dep->station->id,
                            'role' => 'POLICE',
                            'email' => $faker->email,
                            'phone' => $faker->phoneNumber,
                            'password' => Hash::make('secret'),
                            'is_available' => true
                        ]);
                    }
                }
                $admin = $station->employees()->first();
                $station->admin_id = $admin->id;
                $admin->role = 'ADMIN';
                $admin->is_available = null;
                $admin->save();
                $station->save();

                Employee::create([
                    'employee_id' => 'ATT' . $faker->randomNumber(6, true),
                    'name' => $faker->name,
                    'department_id' => null,
                    'station_id' => $station->id,
                    'role' => 'ATTORNEY',
                    'email' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'password' => Hash::make('secret'),
                    'is_available' => true
                ]);
                Employee::create([
                    'employee_id' => 'ATT' . $faker->randomNumber(6, true),
                    'name' => $faker->name,
                    'department_id' => null,
                    'station_id' => $station->id,
                    'role' => 'ATTORNEY',
                    'email' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'password' => Hash::make('secret'),
                    'is_available' => true
                ]);
            }
        }


        for($i = 2; $i <= 6; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('secret'),
                'woreda' => $i
            ]);
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('secret'),
                'woreda' => $i
            ]);
        }
    }
}
