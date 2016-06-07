<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

class ImageController extends Controller
{
    public function studentImage(Request $request, $id)
    {
        $width = $request->input('w');
        $height = $request->input('h');

        $server = ServerFactory::create([
            'source'   => storage_path('uploads/student-images'),
            'cache'    => storage_path('uploads/student-images-cache'),
            'response' => new LaravelResponseFactory()
        ]);

        $extensionFile = storage_path('uploads/student-images/'. domain() . "/{$id}");
        $extension = file_get_contents($extensionFile);
        $extension = trim($extension);

        $image = domain() . "/{$id}.{$extension}";
        $server->outputImage($image, ['w' => $width, 'h' => $height]);
    }
}
