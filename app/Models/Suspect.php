<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable

    // return the finding on which the suspect is added
    public function finding() {
        return $this->belongsTo(Finding::class);
    }

    // create crime record for an existing criminal and give verdict as guilty
    public function foundGuiltyExisting(Criminal $criminal) {
        $this->verdict = 'guilty';
        $this->save();
        $criminal->crime_records()->create([
            'finding_id' => $this->finding->id
        ]);
    }
}
