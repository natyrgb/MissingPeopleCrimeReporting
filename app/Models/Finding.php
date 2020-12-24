<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;

    protected $guarded = ['id'], $with = ['attachments', 'complaint', 'suspects'];


    public function attachments() {
        return $this->morphMany('App\Models\Attachment', 'attachable');
    }

    public function suspects() {
        return $this->hasMany(Suspect::class);
    }

    public function attorney() {
        return $this->belongsTo(Employee::class);
    }

    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }

    public static function openCasesForAttorney($attorney_id) {
        $findings = Finding::where('attorney_id', $attorney_id)->get();
        $open_cases = [];
        if(!$findings->count()) {
            return null;
        }
        else {
            foreach($findings as $finding) {
                if($finding->complaint->status != 'solved') {
                    array_push($open_cases, $finding);
                }
            }
            return collect($open_cases);
        }
    }
}
