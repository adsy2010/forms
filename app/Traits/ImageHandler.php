<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 29/04/2019
 * Time: 18:57
 */

namespace App\Traits;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

trait ImageHandler
{
    public function storeImage($image)
    {
        $image->storeAs('/images/'.microtime().'-'.$image->getClientOriginalName());
    }

    public function deleteImage()
    {

    }
}