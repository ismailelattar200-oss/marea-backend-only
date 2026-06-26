<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use App\Http\Resources\GalleryPhotoResource;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $photos = GalleryPhoto::ordered()->get();
        return GalleryPhotoResource::collection($photos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:10240',
            'image_url' => 'nullable|string',
            'category' => 'required|in:galeria,personal',
            'caption' => 'nullable|string',
            'display_order' => 'required|integer',
        ]);

        if ($request->hasFile('image')) {
             $path = $request->file('image')->store('gallery', 'public');
             $validated['image_url'] = url('storage/' . $path);
        }

        if (empty($validated['image_url'])) {
            return response()->json(['message' => 'Image is required'], 422);
        }

        $photo = GalleryPhoto::create($validated);
        return new GalleryPhotoResource($photo);
    }

    public function update(Request $request, GalleryPhoto $galleryPhoto)
    {
        $validated = $request->validate([
            'category' => 'required|in:galeria,personal',
        ]);

        $galleryPhoto->update($validated);
        return new GalleryPhotoResource($galleryPhoto);
    }

    public function destroy(GalleryPhoto $galleryPhoto)
    {
        $galleryPhoto->delete();
        return response()->json(['message' => 'Photo deleted']);
    }
}
