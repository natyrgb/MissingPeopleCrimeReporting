<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissingPerson extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['attachment'];// eager loads attachments when the object is loaded

    // return attachments of the finding
    public function attachment() {
        return $this->morphOne('App\Models\Attachment', 'attachable');
    }

    // return the user who reported the missing person
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // returns the station in which the missing person is reported
    public function station() {
        return $this->belongsTo(Station::class, 'police_id');
    }

    // returns new missing people in the station idenified by station_id
    public static function newMissingFromStation($station_id) {
        return MissingPerson::where([
            ['station_id', $station_id],
            ['status', 'new']
        ])->get();
    }

    // return missing people reported by the user
    public static function userMissing($user_id) {
        return MissingPerson::where([
            ['user_id', $user_id],
            ['status', '<>', 'found']
        ])->get();
    }

    // over rides delete function to delete the attachment model related to the missing person
    public function delete() {
        $this->attachment()->delete();
        return parent::delete();
    }
}
