<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable

    // returns the station where the department b belongs to
    public function station() {
        return $this->belongsTo(Station::class);
    }

    // returns the employees of the department
    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
