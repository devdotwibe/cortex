<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadfile(Request $request){
        if ($request->hasFile('upload')) {
            $file = $request->file('upload'); 
            $url = $file->store('uploads'); 
            $funcNum = $request->input('CKEditorFuncNum');

            return "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url');</script>";
        }
        return "<script>alert('No file uploaded.');</script>";
    }
}
