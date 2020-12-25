<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['departments'];// eager loads departments when the object is loaded

    // returns the departments of the station
    public function departments() {
        return $this->hasMany(Department::class);
    }

    // returns the employees of the station
    public function employees() {
        return $this->hasMany(Employee::class);
    }

    // returns the admin of the station
    public function admin() {
        return $this->hasOne(Employee::class, 'id', 'admin_id');
    }

    // returns the complaints made to the station
    public function complaints() {
        return $this->hasMany(Complaint::class);
    }

    // returns the missing people reported to the station
    public function missingPeople() {
        return $this->hasMany(MissingPerson::class);
    }

    // returns the attorneys of the station
    public function attorneys() {
        return Employee::where([
            ['station_id', $this->id],
            ['role', 'ATTORNEY']
        ])->get();
    }

    // returns the polices of the station
    public function polices() {
        return Employee::where([
            ['station_id', $this->id],
            ['role', 'POLICE']
        ])->get();
    }

    // overrides the delete function to delete the employees and departments
    public function delete() {
        $this->employees()->delete();
        $this->departments()->delete();
        return parent::delete();
    }
}
