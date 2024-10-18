<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Trait\ResourceController;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    use ResourceController;
    public function __construct()
    {
        self::$model = SubCategory::class;
        self::$routeName = "admin.subcategory";
        self::$defaultActions = [''];

    }

    public function subcategory_table(Request $request)
    {
        if ($request->ajax()) {
 
                if(!empty($request->category)){
                    $category = Category::findSlug($request->category);
                    $this->where('category_id', $category->id);
                }else{
                    $this->where('id', 0);
                }

                return  $this->addAction(function ($data) {

                        if (!empty($data->setname) && count($data->setname) > 0) {

                            return '<!--<a onclick="subcategorysetlist(\'' . route('admin.set.set_store', $data->slug) . '\', \'' . $data->slug . '\')" class="btn btn-icons view_btn">+</a>-->' .

                        
                            '<a onclick="updatesubcategory(\'' . route('admin.subcategory.edit', $data->slug) . '\', \'' . $data->slug . '\' , \'subcategory\')"  class="btn btn-icons edit_btn">
                            <span class="adminside-icon">
                              <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
                            </span>
                        </a>';

                        } else {

                            return '<!--<a onclick="subcategorysetlist(\'' . route('admin.set.set_store', $data->slug) . '\', \'' . $data->slug . '\')" class="btn btn-icons view_btn">+</a>-->' .

                         

                        '<a onclick="updatesubcategory(\'' . route('admin.subcategory.edit', $data->slug) . '\', \'' . $data->slug . '\' , \'subcategory\')"  class="btn btn-icons edit_btn">
                            <span class="adminside-icon">
                              <img src="' . asset("assets/images/icons/iconamoon_edit.svg") . '" alt="Edit">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/iconamoon_edit-yellow.svg") . '" alt="Edit Active">
                            </span>
                        </a>' .


                            


                       '<a  class="btn btn-icons dlt_btn" data-delete="' . route("admin.subcategory.destroy", $data->slug) . '">
                        <span class="adminside-icon">
                            <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                        </span>
                        <span class="adminactive-icon">
                            <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                        </span>
                    </a> ';



                        }

                    })->addColumn('visibility', function ($data) {
                    return '
                            <div class="form-check ">
                                <input type="checkbox"  class="user-visibility form-check-box" name="visibility" value="' . ($data->id) . '" ' . ($data->visible_status == "show" ? "checked" : "") . ' onchange="subcatvisiblechangerefresh(' . "'" . route("admin.subcategory.visibility", $data->slug) . "'" . ')" >
                            </div>
                        ';
                })->buildTable(['visibility']);
 

        }

    }

    public function edit(Request $request, SubCategory $subCategory)
    {
        if ($request->ajax()) {
            $subCategory->updateUrl = route('admin.subcategory.update', $subCategory->slug);
            return response()->json($subCategory);
        }
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $edit_data = $request->validate([

            "name" => "required|unique:sub_categories,name," . $subCategory->id . ",id,category_id," . $subCategory->category_id,
        ]);

        $subCategory->update($edit_data);

        return response()->json(['success', "Sub Category Updated Successfully", 'type' => 'subcategory']);

    }

    public function destroy(Request $request, SubCategory $subCategory)
    {

        $subCategory->delete();

        if ($request->ajax()) {
            return response()->json(["success" => "Subcategory deleted success"]);
        }
        return redirect()->route('admin.category.index')->with("success", "SubCategory deleted success");
    }
    public function visibility(Request $request, SubCategory $subCategory)
    {
        $subCategory->update(['visible_status' => ($subCategory->visible_status ?? "") == "show" ? "hide" : "show"]);
        if ($request->ajax()) {
            return response()->json(["success" => "SubCategory visibility change success"]);
        }
        return redirect()->route('admin.category.index')->with("success", "SubCategory visibility change success");
    }

}
