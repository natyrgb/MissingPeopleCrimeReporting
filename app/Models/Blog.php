<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // guarded makes the id field not insertable
    protected $guarded = ['id'];

    // overrides the created_at attribute into a human readable time like One Day Ago and such
    public function getCreatedAtAttribute() {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }

    //override delete function of the model to delete the attached file in public folder
    public function delete() {
        $path = public_path().'/'.$this->url;
        if($path)
        unlink($path);
        return parent::delete();
    }
}
