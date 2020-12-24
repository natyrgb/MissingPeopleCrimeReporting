<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrimeRecord extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function criminal() {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }

    public function finding() {
        return $this->belongsTo(Finding::class, 'finding_id');
    }
}
