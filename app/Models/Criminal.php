<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criminal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function crimeRecords() {
        return $this->hasMany(CrimeRecord::class);
    }

    public function wanted_criminal() {
        return $this->hasOne(WantedCriminal::class);
    }
}
