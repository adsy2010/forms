<?php


namespace App\Traits;

use Storage;


trait FileHandler
{
    public function storeFile($file)
    {
        $file->storeAs('/docs/'.microtime().'-'.$file->getClientOriginalName());
    }

    public function deleteFile($file)
    {

    }

}