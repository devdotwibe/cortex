<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    
    public function getuploadedFiles(Request $request, $avathar, $name)
    {
        if (Storage::exists($avathar . "/" . $name)) {
            return Storage::response($avathar . "/" . $name);
        }
        else{
            return response()->file(public_path("assets/images/noimage.jpg"));
        }
    }
    public function downloaduploadedFiles(Request $request, $avathar, $name)
    {
        if (Storage::exists($avathar . "/" . $name)) {
            return Storage::download($avathar . "/" . $name);
        }
        else{
            return response()->download(public_path("assets/images/noimage.jpg"));
        }
    }
}
