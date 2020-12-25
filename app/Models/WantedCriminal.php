<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WantedCriminal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['criminal'];// eager loads the criminal connected with wanted criminal

    // returns the criminal connected with wanted criminal
    public function criminal() {
        return $this->belongsTo(Criminal::class);
    }
}
