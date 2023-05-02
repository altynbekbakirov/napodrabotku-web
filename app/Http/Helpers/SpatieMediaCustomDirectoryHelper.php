<?php

namespace App\Http\Helpers;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class SpatieMediaCustomDirectoryHelper implements PathGenerator
{
    public function getPath(Media $media) : string
    {
        // return md5($media->id).'/';
        return $media->model->id .'/';
    }
    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media).'c/';
    }
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'/cri/';
    }
}