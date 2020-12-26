<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Criminal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];// guarded makes the id field not insertable

    // returns the crime records attached to this
    public function crimeRecords() {
        return $this->hasMany(CrimeRecord::class);
    }

    // returns a wanted criminal object if there is a related entry
    public function wanted_criminal() {
        return $this->hasOne(WantedCriminal::class);
    }

    public function saveFile(UploadedFile $file, $type) {
        $imageName = time().'-'.$file->getClientOriginalName();
        $file->move(public_path("images/criminals/$this->name"), $imageName);
        if($type == 'mugshot1')
            $this->mugshot1 = "images/criminals/$this->name/".$imageName;
        else
            $this->mugshot2 = "images/criminals/$this->name/".$imageName;
        $this->save();
    }
}
