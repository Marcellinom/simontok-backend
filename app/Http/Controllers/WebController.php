<?php

namespace App\Http\Controllers;


use Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class WebController extends Controller
{
    function renderImage($type, $id): StreamedResponse
    {
        if (!Storage::disk('public')->has("$type/$id")) abort(404);
        return Storage::disk('public')->download("$type/$id");
    }
}
