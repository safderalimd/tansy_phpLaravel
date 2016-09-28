<?php

namespace App\Http\Photos;

use Image;

class Photo
{
    /**
     * Return a resized version of the student profile picture.
     * If it a resized version does not exist, we will resize the original image.
     */
    public static function studentProfileImage($studentId)
    {
        // if resized image exists
            // return it

        // resize the image if it exists and return it
        $originalImgPath = static::originalStudentPhoto($studentId);
        d($originalImgPath);

        $img = Image::make($originalImgPath);

        $img->resize(30, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $resizedImage = storage_path('uploads/'.domain()."/student-images-30x/{$studentId}.png");
        $img->save($resizedImage);
        d($resizedImage);
        return $resizedImage;

        // return the default image
        return public_path('dashboard/student.png');
    }

    public static function originalStudentPhoto($id)
    {
        $extensionPath = storage_path('uploads/'.domain()."/student-images/{$id}");
        if (file_exists($extensionPath)) {
            $extension = file_get_contents($extensionPath);
            $extension = trim($extension);
            if (file_exists($extensionPath.'.'.$extension)) {
                return $extensionPath.'.'.$extension;
            }
        }

        return null;
    }
}
