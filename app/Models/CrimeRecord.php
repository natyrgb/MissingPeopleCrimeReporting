<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrimeRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable

    //returns the criminal attached with the crime history
    public function criminal() {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }

    //returns the police finding attached with this object
    public function finding() {
        return $this->belongsTo(Finding::class, 'finding_id');
    }
}
