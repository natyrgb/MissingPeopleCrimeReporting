<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['attachments', 'complaint', 'suspects'];// eager loads attachments,complaints,suspects when the object is loaded

    // return attachments of the finding
    public function attachments() {
        return $this->morphMany('App\Models\Attachment', 'attachable');
    }

    // returns the suspects of the case
    public function suspects() {
        return $this->hasMany(Suspect::class);
    }

    // return the attorney handeling the case
    public function attorney() {
        return $this->belongsTo(Employee::class);
    }

    // returns the complaint attached to the case
    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }

    // returns open cases of the attorney with the attorney id
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
    public static function closedCasesForAttorney($attorney_id) {
        $findings = Finding::where('attorney_id', $attorney_id)->get();
        $closed_cases = [];
        if(!$findings->count()) {
            return null;
        }
        else {
            foreach($findings as $finding) {
                if($finding->complaint->status == 'solved') {
                    array_push($closed_cases, $finding);
                }
            }
            return collect($closed_cases);
        }
    }
}
