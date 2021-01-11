<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['attachment'];// allows the attachment relation to be eager loaded with the complaint object


    // overrides the created_at attribute into a human readable time like One Day Ago and such
    public function getCreatedAtAttribute() {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    //returns attachment of the complaint
    public function attachment() {
        return $this->morphOne('App\Models\Attachment', 'attachable');
    }

    //returns user who made the complaint
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //returns the police handeling the case
    public function police() {
        return $this->belongsTo(Employee::class, 'police_id');
    }

    //returns the station in which the complaint is made
    public function station() {
        return $this->belongsTo(Station::class, 'station_id');
    }

    //returns the finding made by the police on the complaint
    public function finding() {
        return $this->hasOne(Finding::class);
    }

    //returns new complaints made in the station identified by the $station_id
    public static function newComplaints($station_id) {
        return Complaint::where([
            ['station_id', $station_id],
            ['status', 'new'],
            ['is_spam', false]
        ])->get();
    }

    //overrides the delete method to delete the related attachment and finding object
    public function delete() {
        $this->attachment()->delete();
        $this->finding()->delete();
        return parent::delete();
    }

    // makes the police available and change the cases status to in_court
    public function inCourt() {
        $this->police->is_available = true;
        $this->police->save();
        $this->status = 'in_court';
        $this->save();
    }

    // change the complaint status from new to under investigation and assign police
    public function underInvestigation($police_id) {
        $police = Employee::find($police_id);
        $this->police_id = $police_id;
        $this->status = 'under_investigation';
        $police->is_available = false;
        $police->save();
        $this->save();
    }

    // report a spam complaint and revoke spammer's account
    public function reportSpam() {
        $this->user->spammer = true;
        $this->user->save();
        $this->police->is_available = true;
        $this->police->save();
        $this->is_spam = true;
        $this->save();
    }

    public static function crime_stat() {
        $stations = Station::all();
        $crimes_with_station = array();
        foreach($stations as $station) {
            $crimes_with_station[$station->name] = $station->complaints()->get()->groupBy('type');
        }
        return $crimes_with_station;
    }
}
