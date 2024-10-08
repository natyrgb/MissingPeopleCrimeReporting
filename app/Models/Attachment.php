<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Attachment extends Model
{
    use HasFactory;

    // guarded makes the id field not insertable
    protected $guarded = ['id'];

    // makes the relation to the model polymorphic meaning different models related through attachable_type
    public function attachable() {
        $this->morphTo();
    }


    //override delete function of the model to delete the attached file in public folder
    public function delete() {
        $path = public_path().'/'.$this->url;
        if($path)
        unlink($path);
        return parent::delete();
    }

    // used to save the file to the attachment
    public function saveFile(UploadedFile $file) {
        $imageName = time().'-'.$file->getClientOriginalName();
        $attachable_type = explode('\\', $this->attachable_type)[sizeof(explode('\\', $this->attachable_type))-1];
        $folder = str_slug($attachable_type);
        $file->move(public_path("images/$folder"), $imageName);
        $this->url = "images/$folder/".$imageName;
        $this->save();
    }
}
