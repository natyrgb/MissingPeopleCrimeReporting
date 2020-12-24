<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WantedCriminal extends Model
{
    use HasFactory;

    protected $guarded = ['id'], $with = ['criminal'];

    public function criminal() {
        return $this->belongsTo(Criminal::class);
    }
}
