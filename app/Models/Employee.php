<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'employees';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'], $with = ['station', 'department'];

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function station() {
        return $this->belongsTo(Station::class);
    }

    public function isPolice() {
        if($this->role == 'POLICE')
            return true;
        return false;
    }

    public function isAttorney() {
        if($this->role == 'ATTORNEY')
            return true;
        return false;
    }

    public function isAdmin() {
        if($this->role == 'ADMIN')
            return true;
        return false;
    }

    public function isSuperAdmin() {
        if($this->role == 'SUPERADMIN')
            return true;
        return false;
    }

    public static function availablePolice($station_id) {
        return Employee::where([
            ['station_id', $station_id],
            ['is_available', true],
            ['role', 'POLICE']
        ])->get();
    }

    public function finding() {
        return $this->hasOne(Finding::class);
    }

    public function attorneyCaseCount() {
        return Finding::where('attorney_id', $this->id)->count();
    }

    public function policeCase() {
        $case = Complaint::where([
            ['police_id', $this->id],
            ['status', 'under_investigation']
        ])->first();
        if($case == null)
            return null;
        return $case;
    }
}
