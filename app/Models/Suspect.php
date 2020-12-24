<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function finding() {
        return $this->belongsTo(Finding::class);
    }

    public function foundGuiltyExisting(Criminal $criminal) {
        $this->verdict = 'guilty';
        $this->save();
        $criminal->crime_records()->create([
            'finding_id' => $this->finding->id
        ]);
    }
}
