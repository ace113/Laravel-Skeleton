<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;

trait UploadTrait
{
    /**
     * UPLOAD IMAGE
     *  
     */  
    public function uploadImage($request, $name = 'image', $folder = 'image')
    {
        $file = $request->file($name);       
        if($file){            
            $fileNameToStore = $this->getFileNameToStore($file);
            
            $path = $file->move(base_path().'/public/uploads/'. $folder, $fileNameToStore);
            
            $destination = public_path('uploads/'.$folder.'/'.$fileNameToStore);

            $image= Image::make($destination)->resize(320, 240)->save();

            return $fileNameToStore;
        }
    }    

    protected function getFileNameToStore($file){
        // get filename with extension
        $fileNameWithExt = $file->getClientOriginalName();

        // get just filename
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

        // get just extention
        $extension = $file->getClientOriginalExtension();

        // Filename to store
        return $fileNameToStore = md5(time().'.'.$file).'.'.$extension;
    }
}