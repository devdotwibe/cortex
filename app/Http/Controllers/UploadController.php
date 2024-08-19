<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    
    public function uploadFile(Request $request)
    {
        switch ($request->file_type) {
            case 'image':
                $request->validate([
                    "file"=>['required','file','max:5120','mimes:jpg,bmp,jpeg,png']
                ]);
                break;
            case 'video':
                $request->validate([
                    "file"=>['required','file','max:10240','mp4,mpeg,mov,mkv']
                ]);
                break;
            case 'document':
                $request->validate([
                    "file"=>['required','file','max:5120','mimes:pdf,doc,docx,xls,xlsx,csv']
                ]);
                break;
            case 'other':
                $request->validate([
                    "file"=>['required','file','max:5120','mimes:'.$request->input('mimes_type','jpg,jpeg,png')]
                ]);
                break;
            default:
                $request->validate([
                    "file"=>['required','file','max:5120','mimes:jpg,bmp,jpeg,png,mp4,mpeg,mov,mkv,pdf,doc,docx,xls,xlsx,csv']
                ]);
                break;
        }

        $avathar = isset($request->foldername) ? $request->foldername : "upload";
        $file = $request->file('file');
        $name = $file->hashName();
        Storage::put("{$avathar}", $file);
        return response()->json([
            'name' => "{$name}",
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'path' => "{$avathar}/{$name}",
            'url' => url("d0/{$avathar}/{$name}"),
            'size' => $file->getSize(),
        ]);
    }
}
