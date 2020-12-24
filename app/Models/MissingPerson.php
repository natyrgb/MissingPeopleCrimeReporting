<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissingPerson extends Model
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

    public function station() {
        return $this->belongsTo(Station::class, 'police_id');
    }

    public static function newMissingFromStation($station_id) {
        return MissingPerson::where([
            ['station_id', $station_id],
            ['status', 'new']
        ])->get();
    }

    public static function userMissing($user_id) {
        return MissingPerson::where([
            ['user_id', $user_id],
            ['status', '<>', 'found']
        ])->get();
    }

    public function delete() {
        $this->attachment()->delete();
        return parent::delete();
    }
}
