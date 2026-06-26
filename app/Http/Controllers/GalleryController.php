<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;
use App\Http\Resources\GalleryPhotoResource;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::ordered()->get();
        return GalleryPhotoResource::collection($photos);
    }
}
