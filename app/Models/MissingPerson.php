<?php

namespace App\Models;

use Carbon\Carbon;
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

    // overrides the created_at attribute into a human readable time like One Day Ago and such
    public function getTimeAttribute() {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    // returns the station in which the missing person is reported
    public function station() {
        return $this->belongsTo(Station::class, 'police_id');
    }

    // returns new missing people in the station idenified by station_id
    public static function newMissingFromStation($station_id) {
        $station = Station::find($station_id);
        return MissingPerson::where([
            ['woreda', $station->woreda],
            ['status', 'new']
        ])->get();
    }

    // return missing people reported by the user
    public static function userMissing($user_id) {
        return MissingPerson::where([
            ['user_id', $user_id],
            ['status', '<>', 'seen']
        ])->get();
    }

    // over rides delete function to delete the attachment model related to the missing person
    public function delete() {
        $this->attachment()->delete();
        return parent::delete();
    }
}
