<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;
use App\Trait\ResourceController;

class HashtagController extends Controller
{
    


    use ResourceController;
    function __construct()
    {
        self::$model=Hashtag::class;
        self::$routeName="admin.community";
        self::$defaultActions=[''];

    }




    function index(Request $request)
    {
        if($request->ajax()){

            return $this->addAction(function($data){ 
                $action= ' 
                 


                   <a onclick="updatehashtag('."'".route('admin.community.hashtags.edit', $data->slug)."'".')"  class="btn btn-icons edit_btn">
    <span class="adminside-icon">
      <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
    </span>
    <span class="adminactive-icon">
        <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
    </span>
</a>



                ';
                if(empty($data->subcategories) || count($data->subcategories) == 0)
                { 
                    $action.=  

                       '<a  class="btn btn-icons dlt_btn" data-delete="'.route("admin.community.hashtags.destroy",$data->slug).'" >
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                        </span>
                    </a> '; 


                } 
                return $action;
            })->buildTable(['visibility']);
        }

        // $category = Category::with('subcategories')->where('id',$id)->first();

        return view('admin.community.hashtags');
    }
    





    public function hashtags()
    {

        return view('admin.community.hashtags'); 
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'hashtag' => 'required|string|max:255|unique:hashtags,name',
        ]);

        // Create a new hashtag
        Hashtag::create([
            'hashtag' => $request->hashtag,
        ]);

        // Return a response, e.g., redirect back with success message
        return redirect()->back()->with('success', 'Hashtag added successfully!');
    }

}
