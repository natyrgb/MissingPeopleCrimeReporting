<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['departments'];

    public function departments() {
        return $this->hasMany(Department::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }

    public function admin() {
        return $this->hasOne(Employee::class, 'id', 'admin_id');
    }

    public function complaints() {
        return $this->hasMany(Complaint::class);
    }

    public function missingPeople() {
        return $this->hasMany(MissingPerson::class);
    }

    public function attorneys() {
        return Employee::where([
            ['station_id', $this->id],
            ['role', 'ATTORNEY']
        ])->get();
    }

    public function polices() {
        return Employee::where([
            ['station_id', $this->id],
            ['role', 'POLICE']
        ])->get();
    }

    public function delete()
    {
        $this->employees()->delete();
        $this->departments()->delete();
        return parent::delete();
    }
}
