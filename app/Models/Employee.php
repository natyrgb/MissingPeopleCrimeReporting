<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'employees';// connects the employee table to the model,because we need it for login
    protected $guarded = ['id'];// guarded makes the id field not insertable
    protected $hidden = ['password', 'remember_token'];// hidden fields on form input
    protected $with = ['station', 'department'];// eager loads the connected station and department

    // returns the department to which the employee belongs to
    public function department() {
        return $this->belongsTo(Department::class);
    }

    // returns the station to which the employee belongs to
    public function station() {
        return $this->belongsTo(Station::class);
    }

    // returns true if this employee is police
    public function isPolice() {
        if($this->role == 'POLICE')
            return true;
        return false;
    }

    // returns true if this employee is attorney
    public function isAttorney() {
        if($this->role == 'ATTORNEY')
            return true;
        return false;
    }

    // returns true if this employee is admin
    public function isAdmin() {
        if($this->role == 'ADMIN')
            return true;
        return false;
    }

    // returns true if this employee is superadmin
    public function isSuperAdmin() {
        if($this->role == 'SUPERADMIN')
            return true;
        return false;
    }

    // returns the findings made by the police
    public function findings() {
        return $this->hasMany(Finding::class);
    }

    // returns polices of the station which are available
    public static function availablePolice($station_id) {
        return Employee::where([
            ['station_id', $station_id],
            ['is_available', true],
            ['role', 'POLICE']
        ])->get();
    }

    // returns the cases of the attorney
    public function attorneyCaseCount() {
        return Finding::where('attorney_id', $this->id)->count();
    }

    // return the police's current case if the employee is police
    public function policeCase() {
        $case = Complaint::where([
            ['police_id', $this->id],
            ['status', 'under_investigation'],
            ['is_spam', false]
        ])->first();
        if($case == null)
            return null;
        return $case;
    }
}
