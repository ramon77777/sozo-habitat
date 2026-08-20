<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Services\PropertyMediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PropertyMediaController extends Controller
{
    public function destroyImage(
        Request $request,
        PropertyImage $propertyImage,
        PropertyMediaService $media
    ): RedirectResponse {
        $media->authorizeProperty(
            $request->user(),
            $propertyImage->property
        );

        $media->deleteImage($propertyImage);

        return back()->with(
            'success',
            'Image supprimÃ©e avec succÃ¨s.'
        );
    }

    public function destroyVideo(
        Request $request,
        PropertyVideo $propertyVideo,
        PropertyMediaService $media
    ): RedirectResponse {
        $media->authorizeProperty(
            $request->user(),
            $propertyVideo->property
        );

        $media->deleteVideo($propertyVideo);

        return back()->with(
            'success',
            'VidÃ©o supprimÃ©e avec succÃ¨s.'
        );
    }
}