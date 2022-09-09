<?php
namespace App\Utility;

class File {

    public const QUIZPATH = "images/quizes";

    public static function imageUpload($file, $folder){
        $imageName = $file->hashName();
        $file->move(public_path()."/".$folder, $imageName);

        return $imageName;

    }

    public static function unlinkPhoto($photo)
    {
        unlink($photo);
    }
}

?>