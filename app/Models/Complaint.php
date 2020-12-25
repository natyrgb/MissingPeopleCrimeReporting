<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $with = ['attachment'];// allows the attachment relation to be eager loaded with the complaint object

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
            ['status', 'new']
        ])->get();
    }

    //overrides the delete method to delete the related attachment and finding object
    public function delete() {
        $this->attachment()->delete();
        $this->finding()->delete();
        return parent::delete();
    }
}
