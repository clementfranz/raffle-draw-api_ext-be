<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/{any}', function () {
    $path = public_path(request()->path());

    if (File::exists($path) && !is_dir($path)) {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $mimeTypes = [
            'js' => 'application/javascript',
            'css' => 'text/css',
            'json' => 'application/json',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject',
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            // add more if needed
        ];

        $mime = $mimeTypes[$extension] ?? File::mimeType($path);

        return Response::file($path, [
            'Content-Type' => $mime,
        ]);
    }

    return File::get(public_path('index.html'));
})->where('any', '^(?!api).*$');
