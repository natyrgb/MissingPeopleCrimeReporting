<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function station() {
        return $this->belongsTo(Station::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
