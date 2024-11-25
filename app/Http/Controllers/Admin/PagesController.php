<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\OurProcess;
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

        $features = Feature::get();

        $courses = Course::first();

        $feed = Feed::get();

        $ourprocess = OurProcess::get();



        return view('admin.pages.home', compact('banner', 'features', 'courses', 'feed','ourprocess'));
    }



    public function store(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'title1' => 'required|string|max:255',
            'subtitle' => 'required|nullable|string|max:255',
            'content' => 'required|nullable|string',
            'buttonlabel' => 'required|nullable|string|max:255',
            'buttonlink' => 'required|nullable|string|max:255',
            // 'image' => 'nullable|image|max:2048', // Validate image
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',

        ]);

        $banner = Banner::first();

        if (empty($banner)) {
            $banner = new Banner;
        }

        $banner->title = $request->input('title1');
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

            'learnimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'learncontent' => 'required|nullable|string',
            'practisetitle' => 'required|nullable|string|max:255',
            'practiseimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'practisecontent' => 'required|nullable|string',
            'preparetitle' => 'required|nullable|string|max:255',
            'prepareimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'preparecontent' => 'required|nullable|string',
            'reviewtitle' => 'required|nullable|string|max:255',
            'reviewimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'reviewcontent' => 'required|nullable|string',
            // Add validation for other fields here
        ]);



        $banner = Banner::first();

        if (empty($banner)) {
            $banner = new Banner;
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
            'ourfeaturestitle' => 'required|nullable|max:255',
            'FeatureHeading' => 'required|nullable|max:255',


            'featuresubtitleupdate.*' => 'required|nullable|string',
            'featurecontentupdate.*' => 'required|nullable|max:255',
            'featureimageupdate.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',

            //  ,['featuresubtitleupdate.*.required' =>'this field is required.']);


        ], [

            'featuresubtitleupdate.*.required' => 'The feature subtitle  field is required.',
            'featurecontentupdate.*.required' => 'The feature content field is required.',
            'featureimageupdate.required' => 'The feature image field is required.',
        ]);



        $banner = Banner::first();

        if (empty($banner)) {
            $banner = new Banner;
        }
        $banner->FeatureHeading = $request->input('FeatureHeading');
        $banner->ourfeaturestitle = $request->input('ourfeaturestitle'); // Save Feature Top Heading


        $banner->save();
        // Retrieve input arrays

        $featuresubtitles = $request->input('featuresubtitle', []);
        $featurecontents = $request->input('featurecontent', []);
        $featureimages = $request->file('featureimage', []);

        $feaids = [];
        // Iterate over the feature titles
        foreach ($featuresubtitles as $key => $title) {
            $feature = new Feature;

            // Set feature date
            $feature->featuresubtitle = $title;
            $feature->featurecontent = $featurecontents[$key];

            // Handle file upload
            if (isset($featureimages[$key])) {
                $featureImage = $featureimages[$key];
                $featureImageName = "features/" . $featureImage->hashName();
                Storage::put('features', $featureImage);
                $feature->image = $featureImageName;
            }


            array_push($feaids, $feature->id);

            $feature->save();
        }


        $featuresubtitles = $request->input('featuresubtitleupdate', []);
        $featurecontents = $request->input('featurecontentupdate', []);
        $featureimages = $request->file('featureimageupdate', []);

        $featureids = $request->input('featureids', []);

        // dd($featureids);



        foreach ($featuresubtitles as $key => $value) {

            if (!empty($featureids[$key])) {



                $feature = Feature::find($featureids[$key]);

                $feature->featuresubtitle = $value;

                $feature->featurecontent = $featurecontents[$key];

                if (isset($featureimages[$key])) {
                    $featureImage = $featureimages[$key];
                    $featureImageName = "features/" . $featureImage->hashName();
                    Storage::put('features', $featureImage);
                    $feature->image = $featureImageName;
                }

                $feature->save();

                array_push($feaids, $feature->id);
            } else {


                $feature = new Feature;

                $feature->featuresubtitle = $value;

                $feature->featurecontent = $featurecontents[$key];

                if (isset($featureimages[$key])) {
                    $featureImage = $featureimages[$key];
                    $featureImageName = "features/" . $featureImage->hashName();
                    Storage::put('features', $featureImage);
                    $feature->image = $featureImageName;
                }

                array_push($feaids, $feature->id);

                $feature->save();
            }
        }

        Feature::whereNotIn('id', $feaids)->delete();



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




    public function storeSection5(Request $request)
    {
        // Validate the request data for Section 4
        $request->validate([
            'exceltitle' => 'required|nullable|string',

            'excelbuttonlabel' => 'required|nullable|string|max:255',
            'excelbuttonlink' => 'required|nullable|string|max:255',
            'excelimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',

        ]);

        $banner = Banner::first();

        if (empty($banner)) {
            $banner = new Banner;
        }

        $banner->exceltitle = $request->input('exceltitle');

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
            'ourcoursetitle' => 'required|nullable|string|max:255',
            'coursetitle' => 'required|nullable|string|max:255',
            'coursesubtitle' => 'required|nullable|string|max:255',
            'courseheading1' => 'required|nullable|string|max:255',
            'coursecontent1' => 'required|nullable|string',
            'courseheading2' => 'required|nullable|string|max:255',
            'coursecontent2' => 'required|nullable|string',
            'courseheading3' => 'required|nullable|string|max:255',
            'coursecontent3' => 'required|nullable|string',
            'courseheading4' => 'required|nullable|string|max:255',
            'coursecontent4' => 'required|nullable|string',
            'coursebuttonlabel' => 'required|nullable|string|max:255',
            'coursebuttonlink' => 'required|nullable|string|max:255',
            'courseimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $courses = Course::first();

        if (empty($courses)) {
            $courses = new Course;
        }
        $courses->ourcoursetitle = $request->input('ourcoursetitle');
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




    public function storeSection8(Request $request)
    {
        // Validate the request data for Section 8
        $request->validate([

            'studenttitle' => 'nullable|string|max:255',
            'studentsubtitle' => 'nullable|string|max:255',
            'percentage' => 'nullable|string|max:255',
            'studentssubtitle' => 'nullable|string|max:255',
            'studentsfeedback' => 'nullable|string|max:255',

            'nameupdate.*' => 'required|string|max:255',
            'starratingupdate.*' => 'required|string',
            'reviewupdate.*' => 'required|string',
            'imageupdate.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',


        ], [

            'nameupdate.*.required' => 'The name  field is required.',
            'starratingupdate.*.required' => 'The star rating field is required.',
            'reviewupdate.required' => 'The review field is required.',
            'imageupdate.required' => 'The image field is required.',
        ]);




        $courses = Course::first();

        if (empty($courses)) {
            $courses = new Course;
        }


        $courses->studenttitle = $request->input('studenttitle');
        $courses->studentsubtitle = $request->input('studentsubtitle');
        $courses->percentage = $request->input('percentage');
        $courses->studentssubtitle = $request->input('studentssubtitle');
        $courses->studentsfeedback = $request->input('studentsfeedback');

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

        $feed = Feed::whereNotIn('id', $feedIds)->get();

        if ($feed) {
       
            foreach($feed as $item)
            {
                if ($item->image && Storage::exists($item->image)) {
                    Storage::delete($item->image);
                }

            }
        }
           
        Feed::whereNotIn('id', $feedIds)->delete();

        // Redirect back with success message
        return redirect()->route('admin.page.index')->with('success', 'Section 7 data has been successfully saved.');
    }





    

// public function destroyy($id)
// {
 
//     $feed = Feed::find($id);

//     if ($feed) {
       
//         if ($feed->image && Storage::exists($feed->image)) {
//             Storage::delete($feed->image);
//         }

      
//         $feed->delete();

      
//         return response()->json(['success' => true]);
//     }

    
//     return response()->json(['success' => false], 404);
// }


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




    public function storeSection9(Request $request)
    {



        // Validate the request data for Section 9
        $request->validate([
            'featurestitle' => 'required|nullable|string',
            'analyticsimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'analyticstitle' => 'required|string|max:255',
            'analyticscontent' => 'required|nullable|string',
            'anytimeimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'anytimetitle' => 'required|required|string|max:255',
            'anytimedescription' => 'required|nullable|string',
            'unlimitedimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'unlimitedtitle' => 'required|string|max:255',
            'unlimitedcontent' => 'required|nullable|string',
            'liveimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
            'livetitle' => 'required|required|string|max:255',
            'livecontent' => 'required|nullable|string',
        ]);

        // Retrieve the first banner or create a new one if none exists
        $banner = Banner::first();

        if (empty($banner)) {
            $banner = new Banner;
        }

        // Assign values from the request to the banner
        $banner->featurestitle = $request->input('featurestitle');
        $banner->analytics_title = $request->input('analyticstitle');
        $banner->analytics_content = $request->input('analyticscontent');
        $banner->anytime_title = $request->input('anytimetitle');
        $banner->anytime_description = $request->input('anytimedescription');
        $banner->unlimited_title = $request->input('unlimitedtitle');
        $banner->unlimited_content = $request->input('unlimitedcontent');
        $banner->live_title = $request->input('livetitle');
        $banner->live_content = $request->input('livecontent');

        // Handle file uploads
        if ($request->hasFile('analyticsimage')) {
            $analyticsImageName = "banner/" . $request->file('analyticsimage')->hashName();
            Storage::put('banner', $request->file('analyticsimage'));
            $banner->analytics_image = $analyticsImageName;
        }

        if ($request->hasFile('anytimeimage')) {
            $anytimeImageName = "banner/" . $request->file('anytimeimage')->hashName();
            Storage::put('banner', $request->file('anytimeimage'));
            $banner->anytime_image = $anytimeImageName;
        }

        if ($request->hasFile('unlimitedimage')) {
            $unlimitedImageName = "banner/" . $request->file('unlimitedimage')->hashName();
            Storage::put('banner', $request->file('unlimitedimage'));
            $banner->unlimited_image = $unlimitedImageName;
        }

        if ($request->hasFile('liveimage')) {
            $liveImageName = "banner/" . $request->file('liveimage')->hashName();
            Storage::put('banner', $request->file('liveimage'));
            $banner->live_image = $liveImageName;
        }

        // Save the banner
        $banner->save();

        return redirect()->route('admin.page.index')->with('success', 'Section 4 data has been successfully saved.');
    }


    public function storeSection10(Request $request)
{
    // Validate the request data for Section 10
    $request->validate([
        'ourprocesstitle' => 'required|nullable|max:255',
        'ourprocesssubtitle' => 'required|nullable|max:255',
        'ourprocessheadingupdate.*' => 'required|nullable|string',
        'ourprocessimageupdate.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
    ], [
        'ourprocessheadingupdate.*.required' => 'The Process Heading field is required.',
        'ourprocessimageupdate.*.required' => 'The process image field is required.',
    ]);

    // Save banner data
    $banner = Banner::first();
    if (empty($banner)) {
        $banner = new Banner;
    }
    $banner->ourprocesstitle = $request->input('ourprocesstitle');
    $banner->ourprocesssubtitle = $request->input('ourprocesssubtitle');
    $banner->save();

    $ourprocessheadings = $request->input('ourprocessheadingupdate', []);
    $ourprocessimages = $request->file('ourprocessimageupdate', []);
    $processids = $request->input('processids', []);

    $proids = [];

    // Iterate over the feature headings
    foreach ($ourprocessheadings as $key => $heading) {
        $process = isset($processids[$key]) ? OurProcess::find($processids[$key]) : new OurProcess;

        // Set process heading
        $process->ourprocessheading = $heading;

        // // Handle file upload
        // if (isset($ourprocessimages[$key]) && $ourprocessimages[$key] instanceof \Illuminate\Http\UploadedFile) {
        //     $image = $ourprocessimages[$key];
        //     $imagePath = 'features/' . $image->hashName();
        //     $image->storeAs('features', $image->hashName()); // Store the image
        //     $process->ourprocessimage = $imagePath;
        // }

        
         if (isset($ourprocessimages[$key])) {
            $image = $ourprocessimages[$key];
            $imagePath = 'features/' . $image->hashName();
            Storage::put('features', $image);
            $process->ourprocessimage = $imagePath;

           
        }

        $process->save();
        $proids[] = $process->id;
    }

    // Delete processes that were not in the submitted data
    OurProcess::whereNotIn('id', $proids)->delete();

    // Redirect back with success message
    return redirect()->route('admin.page.index')->with('success', 'Section 4 data has been successfully saved.');
}







    public function destroyyyy($id)
    {
        $process = OurProcess::find($id);

        if ($process) {
            // Delete the feature from the database
            $process->delete();

            // Return a success response
            return response()->json(['success' => true]);
        }

        // Return a failure response if feature not found
        return response()->json(['success' => false], 404);
    }



    public function deleteImage(Request $request)
    {
        // Validate the image path
        $request->validate([
            'image_path' => 'required|string',
        ]);
    
        // Retrieve the image path from the request
        $imagePath = $request->input('image_path');
        
        // Check if the image file exists in storage
        if (Storage::exists($imagePath)) {
            
            Storage::delete($imagePath);
            // Find the first Banner instance and update it
            $banner = Banner::first();
            if ($banner && $banner->image === $imagePath) {
              
                // Clear the image field in the database
                $banner->image = null;
                $banner->save();
            }
    
            // Return a success response
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }
    
        // Return an error response if the image file does not exist
        return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
    }
    
    public function deleteLearnImage(Request $request)
    {
        // Validate the image path
        $request->validate([
            'image_path' => 'required|string',
        ]);
    
        // Retrieve the image path from the request
        $imagePath = $request->input('image_path');
        
        // Check if the image file exists in storage
        if (Storage::exists($imagePath)) {
            // Delete the image file from storage
            Storage::delete($imagePath);
    
            // Find the Banner instance and update the image field
            $banner = Banner::first(); // Find the first banner or adjust based on your logic
            if ($banner && $banner->learnimage === $imagePath) {
                // Clear the learnimage field in the database
                $banner->learnimage = null;
                $banner->save();
            }
    
            // Return a success response
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }
    
        // Return an error response if the image file does not exist
        return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
    }

    public function deletePractiseImage(Request $request)
    {
        // Validate the image path
        $request->validate([
            'image_path' => 'required|string',
        ]);
    
        // Retrieve the image path from the request
        $imagePath = $request->input('image_path');
        
        // Check if the image file exists in storage
        if (Storage::exists($imagePath)) {
            // Delete the image file from storage
            Storage::delete($imagePath);
    
            // Find the Banner instance and update the image field
            $banner = Banner::first(); // Find the first banner or adjust based on your logic
            if ($banner && $banner->practiseimage === $imagePath) {
                // Clear the practiseimage field in the database
                $banner->practiseimage = null;
                $banner->save();
            }
    
            // Return a success response
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }
    
        // Return an error response if the image file does not exist
        return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
    }

    public function deletePrepareImage(Request $request)
{
    $request->validate([
        'image_path' => 'required|string',
    ]);

    $imagePath = $request->input('image_path');

    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner and update the image field
        $banner = Banner::first(); // Adjust as needed
        if ($banner && $banner->prepareimage === $imagePath) {
            $banner->prepareimage = null;
            $banner->save();
        }

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteReviewImage(Request $request)
{
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance and update the review image field
        $banner = Banner::first(); // Adjust this logic as needed
        if ($banner && $banner->reviewimage === $imagePath) {
            // Clear the reviewimage field in the database
            $banner->reviewimage = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteExcelImage(Request $request)
{
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance and update the excel image field
        $banner = Banner::first(); // Adjust this logic as needed
        if ($banner && $banner->excelimage === $imagePath) {
            // Clear the excelimage field in the database
            $banner->excelimage = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteAnalyticsImage(Request $request)
{
    // Validate the image path
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance (adjust the query as needed)
        $banner = Banner::first(); // You might need to adjust this if you're targeting a specific banner
        if ($banner && $banner->analytics_image === $imagePath) {
            // Clear the analytics_image field in the database
            $banner->analytics_image = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Analytics image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteAnytimeImage(Request $request)
{
    // Validate the image path
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance (adjust as needed)
        $banner = Banner::first(); // Adjust this if targeting a specific banner
        if ($banner && $banner->anytime_image === $imagePath) {
            // Clear the anytime_image field in the database
            $banner->anytime_image = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Anytime image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteUnlimitedImage(Request $request)
{
    // Validate the image path
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance (adjust as needed)
        $banner = Banner::first(); // Adjust this if targeting a specific banner
        if ($banner && $banner->unlimited_image === $imagePath) {
            // Clear the unlimited_image field in the database
            $banner->unlimited_image = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Unlimited image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteLiveImage(Request $request)
{
    // Validate the image path
    $request->validate([
        'image_path' => 'required|string',
    ]);

    // Retrieve the image path from the request
    $imagePath = $request->input('image_path');

    // Check if the image exists in storage
    if (Storage::exists($imagePath)) {
        // Delete the image from storage
        Storage::delete($imagePath);

        // Find the Banner instance (adjust as needed)
        $banner = Banner::first(); // Adjust this if targeting a specific banner
        if ($banner && $banner->live_image === $imagePath) {
            // Clear the live_image field in the database
            $banner->live_image = null;
            $banner->save();
        }

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Live image deleted successfully']);
    }

    // Return an error response if the image is not found
    return response()->json(['success' => false, 'message' => 'Image file not found.'], 404);
}


public function deleteFeatureImage(Request $request)
{

    $feature = Feature::find($request->id);

    if ($feature) {
        // Get the image path from the request
        $imagePath = $feature->image ;

        // Check if the file exists in the storage and delete it
        if (Storage::exists($imagePath)) {
            // Delete the image from storage
            Storage::delete($imagePath);

            // Update the feature record to remove the image from the database
            $feature->image = null;
            $feature->save();

            // Return a success response
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        } else {
            // If the file doesn't exist
            return response()->json(['success' => false, 'message' => 'Image not found']);
        }
    }

    // If the feature doesn't exist
    return response()->json(['success' => false, 'message' => 'Feature not found']);
}


public function deleteProcessImage(Request $request)
{
    // Find the process record by its ID
    $process = OurProcess::find($request->id);

    if ($process) {
        // Get the image path from the process record
        $imagePath = $process->ourprocessimage;

        // Check if the image exists in storage and delete it
        if (Storage::exists($imagePath)) {
            // Delete the image from storage
            Storage::delete($imagePath);

            // Update the process record to remove the image
            $process->ourprocessimage = null;
            $process->save();

            // Return a success response
            return response()->json(['success' => true, 'message' => 'Process image deleted successfully']);
        } else {
            // If the image doesn't exist in storage
            return response()->json(['success' => false, 'message' => 'Process image not found']);
        }
    }

    // If the process doesn't exist
    return response()->json(['success' => false, 'message' => 'Process not found']);
}


public function deleteImagesection7(Request $request)
{
    
   

    // Find the feed record by its ID
    $feed = Feed::find($request->id);

    if ($feed) {
    
        $imagePath = $feed->image;
     
           
            if (Storage::exists($imagePath)) {
             
                Storage::delete($imagePath);
             
            $feed->image = null;
            $feed->save();

            
             return response()->json(['success' => true, 'message' => 'Process image deleted successfully']);
            } else {
                
                return response()->json(['success' => false, 'message' => 'Process image not found']);
            }
        }
    
      
        return response()->json(['success' => false, 'message' => 'Process not found']);
    }
    
}
   

        
