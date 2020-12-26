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

        foreach($stations as $station) {
            if($station->id != 1) {
                $employee = $station->employees()->first();
                $station->admin_id = $employee->id;
                $employee->role = 'ADMIN';
                $employee->is_available = null;
                $employee->save();
                $station->save();

                Employee::create([
                    'employee_id' => 'ATT' . $faker->randomNumber(6, true),
                    'name' => $faker->name,
                    'department_id' => null,
                    'station_id' => $dep->station->id,
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
                    'station_id' => $dep->station->id,
                    'role' => 'ATTORNEY',
                    'email' => $faker->email,
                    'phone' => $faker->phoneNumber,
                    'password' => Hash::make('secret'),
                    'is_available' => true
                ]);
            }
        }


        for($i = 2; $i <= 6; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('secret'),
                'woreda' => $i
            ]);
            $station = Station::find($i);

            for($j = 0; $j < 6; $j++) {
                $user->complaints()->create([
                    'station_id' => $station->id,
                    'type' => $departments[random_int(0,4)],
                    'details' => $faker->paragraph(5),
                    'created_at' => $faker->dateTimeThisYear
                ]);
                /*
                $path = 'images/complaint';
                $complaint->attachment()->create([
                    'attachable_id' => $complaint->id,
                    'attachable_type' => 'complaints',
                    'url' => $faker->image(public_path($path), 400, 300, null, false)
                ]);*/

                $user->missingPeople()->create([
                    'name' => $faker->name,
                    'description' => $faker->paragraph(5),
                    'time' => $faker->dateTimeThisYear,
                    'created_at' => $faker->dateTimeThisYear,
                    'woreda' => $station->woreda
                ]);
                /*
                $path = 'images/missingperson';
                $missing->attachment()->create([
                    'attachable_id' => $missing->id,
                    'attachable_type' => 'missing_people',
                    'url' => $faker->image(public_path($path), 400, 300, null, false)
                ]);*/
            }
        }
        /*
        $path = 'images/criminal';
        for($i = 0; $i < 4; $i++) {
            Criminal::create([
                'citizen_id' => $faker->bankAccountNumber,
                'name' => $faker->name,
                'birthdate' => $faker->date('Y-m-d', '2002-01-01'),
                'gender' => 'male',
                'address' => $faker->address,
                'occupation' => 'unemployed',
                'mugshot1' => $faker->image(public_path($path), 400, 300, null, false)
            ]);
        }
        $path = 'images/blog';
        for($i = 0; $i < 4; $i++) {
            Blog::create([
                'title' => $faker->title,
                'url' => $faker->image(public_path($path), 400, 300, null, false),
                'article' => $faker->paragraph(6),
                'created_at' => $faker->dateTimeThisWeek
            ]);
        }*/
    }
}
