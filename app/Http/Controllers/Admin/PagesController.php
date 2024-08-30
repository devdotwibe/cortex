<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\banner; // Import the Banner model
use App\Models\Course;
use App\Models\Feed;
use Illuminate\Support\Facades\Storage;
use Stripe\Service\CountrySpecService;

class PagesController extends Controller
{
    public function index()
    {
        $banner = Banner::first();

        $feature = Feature::get();

        $courses = Course::first();

        $feed = Feed::get();


        return view('admin.pages.home', compact('banner','feature','courses','feed'));
    }

    // public function store(Request $request)
    // {
    //     // Determine which section's form was submitted
    //     $action = $request->input('action');

    //     if ($action == 'save') {
    //         $this->saveSection1($request);
    //     } elseif ($action == 'submit') {
    //         $this->storeSection2($request);
    //     }

    //     // Redirect back to the home page with a success message
    //     return redirect()->route('admin.page.index')->with('success', 'Success.');
    // }

    public function store(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'buttonlabel' => 'nullable|string|max:255',
            'buttonlink' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // Validate image
        ]);

        $banner = Banner::first();

        if(empty($banner))
        {
            $banner =new Banner;
        }

        $banner->title = $request->input('title');
        $banner->subtitle = $request->input('subtitle');
        $banner->content = $request->input('content');
        $banner->buttonlabel = $request->input('buttonlabel');
        $banner->buttonlink = $request->input('buttonlink');

        if ($request->hasFile('image')) {
            $imageName = "banner/" . $request->file('image')->hashName();
            Storage::put('banner', $request->file('image'));
            $banner->image = $imageName;
        }



        $banner->save();

        return redirect()->route('admin.page.index')->with('success', 'Section 1 data has been successfully saved.');
    }

    public function storeSection2(Request $request)
    {
        // Validate the request data for Section 2
        $request->validate([
            'guaranteetitle' => 'required|string|max:255',
            'learntitle' => 'required|string|max:255',

            'learnimage' => 'nullable|image|max:2048',
            'learncontent' => 'nullable|string',
            'practisetitle' => 'nullable|string|max:255',
            'practiseimage' => 'nullable|image|max:2048',
            'practisecontent' => 'nullable|string',
            'preparetitle' => 'nullable|string|max:255',
            'prepareimage' => 'nullable|image|max:2048',
            'preparecontent' => 'nullable|string',
            'reviewtitle' => 'nullable|string|max:255',
            'reviewimage' => 'nullable|image|max:2048',
            'reviewcontent' => 'nullable|string',
            // Add validation for other fields here
        ]);



        $banner = Banner::first();

        if(empty($banner))
        {
            $banner =new Banner;
        }

        $banner->guaranteetitle = $request->input('guaranteetitle');
        $banner->learntitle = $request->input('learntitle');
        $banner->learncontent = $request->input('learncontent');
        $banner->practisetitle = $request->input('practisetitle');
        $banner->practisecontent = $request->input('practisecontent');
        $banner->preparetitle = $request->input('preparetitle');
        $banner->preparecontent = $request->input('preparecontent');
        $banner->reviewtitle = $request->input('reviewtitle');
        $banner->reviewcontent = $request->input('reviewcontent');
        if ($request->hasFile('learnimage')) {
            $learnImageName = "banner/" . $request->file('learnimage')->hashName();
            Storage::put('banner', $request->file('learnimage'));
            $banner->learnimage = $learnImageName;
        }

        if ($request->hasFile('practiseimage')) {
            $practiseImageName = "banner/" . $request->file('practiseimage')->hashName();
            // $practiseImageName = $request->file('practiseimage')->store('banner', 'public');
            Storage::put('banner', $request->file('practiseimage'));
            $banner->practiseimage = $practiseImageName;
        }
        if ($request->hasFile('prepareimage')) {
            $prepareImageName = "banner/" . $request->file('prepareimage')->hashName();
            // $practiseImageName = $request->file('practiseimage')->store('banner', 'public');
            Storage::put('banner', $request->file('prepareimage'));
            $banner->prepareimage = $prepareImageName;
        }

        if ($request->hasFile('reviewimage')) {
            $reviewImageName = "banner/" . $request->file('reviewimage')->hashName();
            // $practiseImageName = $request->file('practiseimage')->store('banner', 'public');
            Storage::put('banner', $request->file('reviewimage'));
            $banner->reviewimage = $reviewImageName;
        }

        $banner->save();
        return redirect()->route('admin.page.index')->with('success', 'Section 2 data has been successfully saved.');

    }

    public function storeSection3(Request $request)
    {
        // Validate the request data for Section 3
        $request->validate([

            'featuresubtitle.*' => 'nullable|string|max:255',
            'featurecontent.*' => 'nullable|string',
            'featureimage.*' => 'nullable|image|max:2048', // Validate image
            'FeatureHeading' => 'nullable|max:255',
        ]);


        $banner = Banner::first();

        if(empty($banner))
        {
            $banner =new Banner;
        }
        $banner->FeatureHeading = $request->input('FeatureHeading'); // Save Feature Top Heading




        $banner->save();
        // Retrieve input arrays

        $featuresubtitles = $request->input('featuresubtitle', []);
        $featurecontents = $request->input('featurecontent', []);
        $featureimages = $request->file('featureimage', []);

        $feaids=[];
        // Iterate over the feature titles
        foreach ($featuresubtitles as $key => $title) {
            $feature = new Feature;

            // Set feature date
            $feature->featuresubtitle = $title;
            $feature->featurecontent = $featurecontents[$key] ;

            // Handle file upload
            if (isset($featureimages[$key])) {
                $featureImage = $featureimages[$key];
                $featureImageName = "features/" . $featureImage->hashName();
                Storage::put('features', $featureImage);
                $feature->image = $featureImageName;
            }


            array_push($feaids,$feature->id);

            $feature->save();

        }

        $featuresubtitles = $request->input('featuresubtitleupdate', []);
        $featurecontents = $request->input('featurecontentupdate', []);
        $featureimages = $request->file('featureimageupdate', []);

        $featureids = $request->input('featureids', []);

        // dd($featureids);



        foreach ($featuresubtitles as $key=> $value) {

            if(!empty($featureids[$key]))
            {

                $feature =Feature::find($featureids[$key]);

                $feature->featuresubtitle = $value;

                $feature->featurecontent = $featurecontents[$key];

                if (isset($featureimages[$key])) {
                    $featureImage = $featureimages[$key];
                    $featureImageName = "features/" . $featureImage->hashName();
                    Storage::put('features', $featureImage);
                    $feature->image = $featureImageName;
                }

                $feature->save();

                array_push($feaids,$feature->id);

            }else{

                $feature = new Feature;

                $feature->featuresubtitle = $value;

                $feature->featurecontent = $featurecontents[$key];

                if (isset($featureimages[$key])) {
                    $featureImage = $featureimages[$key];
                    $featureImageName = "features/" . $featureImage->hashName();
                    Storage::put('features', $featureImage);
                    $feature->image = $featureImageName;
                }

                array_push($feaids,$feature->id);

                $feature->save();
            }

        }

        Feature::whereNotIn('id',$feaids)->delete();



        // Redirect back with success message
        return redirect()->route('admin.page.index')->with('success', 'Section 3 data has been successfully saved.');
    }









    public function destroy($id)
{
    $feature = Feature::find($id);

    if ($feature) {
        // Delete the feature from the database
        $feature->delete();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if feature not found
    return response()->json(['success' => false], 404);
}









    // public function storeSection4(Request $request)
    // {
    //     // Validate the request data for Section 3
    //     $request->validate([
    //         'FeatureHeading' => 'nullable|max:255',
    //     ]);

    //     $banner = Banner::first();

    //     if(empty($banner))
    //     {
    //         $banner =new Banner;
    //     }
    //     $banner->FeatureHeading = $request->input('FeatureHeading'); // Save Feature Top Heading




    //     $banner->save();

    //     return redirect()->route('admin.page.index')->with('success', 'Section 4 data has been successfully saved.');
    // }


    public function storeSection5(Request $request)
    {
        // Validate the request data for Section 4
        $request->validate([
            'exceltitle' => 'nullable|string|max:255',
            'excelsubtitle' => 'nullable|string|max:255',
            'subtitle1' => 'nullable|string|max:255',
            'subtitle2' => 'nullable|string|max:255',
            'subtitle3' => 'nullable|string|max:255',
            'excelbuttonlabel' => 'nullable|string|max:255',
            'excelbuttonlink' => 'nullable|string|max:255',
            'excelimage' => 'nullable|image|max:2048', // Validate image

        ]);

        $banner = Banner::first();

        if(empty($banner))
        {
            $banner = new Banner;
        }

        $banner->exceltitle = $request->input('exceltitle');
        $banner->excelsubtitle = $request->input('excelsubtitle');
        $banner->subtitle1 = $request->input('subtitle1');
        $banner->subtitle2 = $request->input('subtitle2');
        $banner->subtitle3 = $request->input('subtitle3');
        $banner->excelbuttonlabel = $request->input('excelbuttonlabel');
        $banner->excelbuttonlink = $request->input('excelbuttonlink');

        if ($request->hasFile('excelimage')) {
            $imageName = "banner/" . $request->file('excelimage')->hashName();
            Storage::put('banner', $request->file('excelimage'));
            $banner->excelimage = $imageName;
        }




        $banner->save();

        return redirect()->route('admin.page.index')->with('success', 'Section 5 data has been successfully saved.');
    }

    public function storeSection6(Request $request)
{
    // Validate the request data for Section 5
    $request->validate([
        'coursetitle' => 'nullable|string|max:255',
        'coursesubtitle' => 'nullable|string|max:255',
        'courseheading1' => 'nullable|string|max:255',
        'coursecontent1' => 'nullable|string',
        'courseheading2' => 'nullable|string|max:255',
        'coursecontent2' => 'nullable|string',
        'courseheading3' => 'nullable|string|max:255',
        'coursecontent3' => 'nullable|string',
        'courseheading4' => 'nullable|string|max:255',
        'coursecontent4' => 'nullable|string',
        'coursebuttonlabel' => 'nullable|string|max:255',
        'coursebuttonlink' => 'nullable|string|max:255',
        'courseimage' => 'nullable|image|max:2048', // Validate image
    ]);

    $courses = Course::first();

    if (empty($courses)) {
        $courses = new Course;
    }

    $courses->coursetitle = $request->input('coursetitle');
    $courses->coursesubtitle = $request->input('coursesubtitle');
    $courses->courseheading1 = $request->input('courseheading1');
    $courses->coursecontent1 = $request->input('coursecontent1');
    $courses->courseheading2 = $request->input('courseheading2');
    $courses->coursecontent2 = $request->input('coursecontent2');
    $courses->courseheading3 = $request->input('courseheading3');
    $courses->coursecontent3 = $request->input('coursecontent3');
    $courses->courseheading4 = $request->input('courseheading4');
    $courses->coursecontent4 = $request->input('coursecontent4');
    $courses->coursebuttonlabel = $request->input('coursebuttonlabel');
    $courses->coursebuttonlink = $request->input('coursebuttonlink');

    if ($request->hasFile('courseimage')) {
        $imageName = "course/" . $request->file('courseimage')->hashName();
        Storage::put('course', $request->file('courseimage'));
        $courses->courseimage = $imageName;
    }

    $courses->save();

    return redirect()->route('admin.page.index')->with('success', 'Section 6 data has been successfully saved.');
}



// public function storeSection7(Request $request)
// {
//     // Validate the request data for Section 6
//     $request->validate([
//         'studenttitle' => 'nullable|string|max:255',
//         'studentsubtitle' => 'nullable|string|max:255',
//     ]);


//     $courses = Course::first();

//     if (empty($courses)) {
//         $courses = new Course;
//     }


//     $courses->studenttitle = $request->input('studenttitle');
//     $courses->studentsubtitle = $request->input('studentsubtitle');

//     $courses->save();

//     return redirect()->route('admin.page.index')->with('success', 'Section 6 data has been successfully saved.');
// }



public function storeSection8(Request $request)
{
    // Validate the request data for Section 8
    $request->validate([
        'name.*' => 'nullable|string|max:255',
        'starrating.*' => 'nullable|string',
        'review.*' => 'nullable|string',
        'image.*' => 'nullable|image',
        'studenttitle' => 'nullable|string|max:255',
        'studentsubtitle' => 'nullable|string|max:255',
    ]);



    $courses = Course::first();

    if (empty($courses)) {
        $courses = new Course;
    }


    $courses->studenttitle = $request->input('studenttitle');
    $courses->studentsubtitle = $request->input('studentsubtitle');

    $courses->save();

    // Retrieve input arrays
    $names = $request->input('name', []);
    $starratings = $request->input('starrating', []);
    $reviews = $request->input('review', []);
    $images = $request->file('image', []);

    // Initialize the feedIds array
    $feedIds = [];

    // Iterate over the input arrays to create or update feeds
    foreach ($names as $key => $name) {
        $feed = new Feed;

        // Set feed data
        $feed->name = $name;
        $feed->starrating = $starratings[$key] ?? null;
        $feed->review = $reviews[$key] ?? null;

        // Handle file upload
        if (isset($images[$key])) {
            $image = $images[$key];
            $feedImageName = "feed/" . $image->hashName();
            Storage::put('feed', $image);
            $feed->image = $feedImageName;
        }

        $feed->save();
        $feedIds[] = $feed->id; // Using array_push is optional, you can just append to the array like this
    }

    // Handle updates for existing feeds
    $namesUpdate = $request->input('nameupdate', []);
    $starratingsUpdate = $request->input('starratingupdate', []);
    $reviewsUpdate = $request->input('reviewupdate', []);
    $imagesUpdate = $request->file('imageupdate', []);
    $feedidsUpdate = $request->input('feedids', []);

    foreach ($namesUpdate as $key => $value) {
        if (!empty($feedidsUpdate[$key])) {
            $feed = Feed::find($feedidsUpdate[$key]);

            if ($feed) {
                $feed->name = $value;
                $feed->starrating = $starratingsUpdate[$key] ?? null;
                $feed->review = $reviewsUpdate[$key] ?? null;

                // Handle file upload for update
                if (isset($imagesUpdate[$key])) {
                    $image = $imagesUpdate[$key];
                    $feedImageName = "feed/" . $image->hashName();
                    Storage::put('feed', $image);
                    $feed->image = $feedImageName;
                }

                $feed->save();
                $feedIds[] = $feed->id;
            }
        }
    }

    // Delete feeds that were not included in the request
    Feed::whereNotIn('id', $feedIds)->delete();

    // Redirect back with success message
    return redirect()->route('admin.page.index')->with('success', 'Section 6 data has been successfully saved.');
}








public function destroyy($id)
{
$feed = Feed::find($id);

if ($feed) {
    // Delete the feature from the database
    $feed->delete();

    // Return a success response
    return response()->json(['success' => true]);
}

// Return a failure response if feature not found
return response()->json(['success' => false], 404);
}




}






