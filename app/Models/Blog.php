<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function getCreatedAtAttribute() {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }
}
