<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;
use App\Trait\ResourceController;
use Yajra\DataTables\Facades\DataTables;

class HashtagController extends Controller
{



    public function hashtags()
    {

        return view('admin.community.hashtags'); 
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch all hashtags
            $hashtags = Hashtag::where('id',">",0);

            return DataTables::of($hashtags)
                ->addColumn('action', function ($data) {
                    return
                        '<a onclick="editHashtag('."'".route('admin.community.hashtags.edit', $data->id)."'".')" class="btn btn-icons edit_btn">
                            <span class="adminside-icon">
                                <img src="'.asset('assets/images/icons/iconamoon_edit.svg').'" alt="Edit">
                            </span>
                            <span class="adminactive-icon">
                                <img src="'.asset('assets/images/iconshover/iconamoon_edit-yellow.svg').'" alt="Edit Active">
                            </span>
                        </a>' .
                        '<a onclick="deleteHashtag('."'".route('admin.community.hashtags.destroy', $data->id)."'".')" class="btn btn-icons delete_btn">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                            </span>
                        </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.community.hashtags'); // Make sure this view exists
    }


    public function store(Request $request)
    {
        $request->validate([
            'hashtag' => 'required|string|max:255',
        ]);

        Hashtag::create($request->all());
        return redirect()->route('admin.community.hashtags')->with('success', 'Hashtag created successfully.');
    }

    public function edit($id)
    {
        $hashtag = Hashtag::findOrFail($id);
        return view('admin.community.hashtags.edit', compact('hashtag')); // Edit view
    }

   
}
