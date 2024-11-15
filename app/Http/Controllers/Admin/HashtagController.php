<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Hashtag;
use Illuminate\Http\Request;

use App\Models\Hashtagstore;
use App\Trait\ResourceController;
use Yajra\DataTables\Facades\DataTables;

class HashtagController extends Controller
{



    public function hashtags(Request $request)
    {
        if ($request->ajax()) {

            
            // Fetch all hashtags
            $hashtags = Hashtag::where('id',">",0);

            return DataTables::of($hashtags)
                ->addColumn('action', function ($data) {

                        return
                        // '<a onclick="editHashtag('."'".route('admin.community.hashtags.edit', $data->id)."'".')" class="btn btn-icons edit_btn">
                        //     <span class="adminside-icon">
                        //         <img src="'.asset('assets/images/icons/iconamoon_edit.svg').'" alt="Edit">
                        //     </span>
                        //     <span class="adminactive-icon">
                        //         <img src="'.asset('assets/images/iconshover/iconamoon_edit-yellow.svg').'" alt="Edit Active" title="Edit">
                        //     </span>
                        // </a>' .
                        '<a onclick="deleteHashtag('."'".route('admin.community.hashtags.destroy', $data->id)."'".')" class="btn btn-icons delete_btn">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active" title="Delete">
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
            'hashtag' => [
                'required',
                'regex:/^#\w+$/', 
            ],
        ], [
            'hashtag.regex' => 'The hashtag must start with a # symbol',
        ]);

      
        $hashtag = new Hashtag();
        $hashtag->hashtag = $request->hashtag; 
      
        $hashtag->save();

 
        return response()->json(['success' => true, 'message' => 'Hashtag added successfully.']);
    }


    public function destroy($id)
    {
        // Find the hashtag or fail
        $hashtag = Hashtag::findOrFail($id);
        // $hashtagPosts = Hashtag::where('hashtagstore_id',$hashtag->id)->delete();
        $hashtag->delete();
    
        return redirect()->back()->with('success', 'Hashtag deleted successfully.');
    }
    
    public function edit($id)
    {
        // Find the hashtag or fail
        $hashtag = Hashtag::findOrFail($id);
        
        // Return a view with the hashtag data (you might need to create this view)
        return response()->json($hashtag);
    }
    
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'hashtag' => 'required',
        ]);
    
        // Find the hashtag or fail
        $hashtag = Hashtag::findOrFail($id);
    
        // Update the hashtag with the new value
        $hashtag->hashtag = $request->hashtag;
        $hashtag->save();
    
        return response()->json(['success' => true, 'message' => 'Hashtag updated successfully.']);
    }
    



   
   
}
