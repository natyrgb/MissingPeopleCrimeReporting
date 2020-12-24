<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['attachment'];

    public function attachment() {
        return $this->morphOne('App\Models\Attachment', 'attachable');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function police() {
        return $this->belongsTo(Employee::class, 'police_id');
    }

    public function station() {
        return $this->belongsTo(Station::class, 'station_id');
    }

    public function finding() {
        return $this->hasOne(Finding::class);
    }

    public static function newComplaints($station_id) {
        return Complaint::where([
            ['station_id', $station_id],
            ['status', 'new']
        ])->get();
    }

    public function delete()
    {
        $this->attachment()->delete();
        $this->finding()->delete();
        return parent::delete();
    }
}
