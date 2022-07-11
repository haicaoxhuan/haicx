<?php

namespace App\Services;

class UploadService
{
    public function store($file)
    {
        $name = $file->getClientOriginalName();
        $image = 'upload/product/' . $name;
        $file->move("upload/product/", $image);
        return $image;
    }
}
