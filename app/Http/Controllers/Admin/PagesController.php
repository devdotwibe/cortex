<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\banner; // Import the Banner model
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function index()
    {
        $banner = Banner::first();

        $feature = Feature::get();

        return view('admin.pages.home', compact('banner','feature'));
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
        ]);

        // Retrieve input arrays

        $featuresubtitles = $request->input('featuresubtitle', []);
        $featurecontents = $request->input('featurecontent', []);
        $featureimages = $request->file('featureimage', []);

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

            // Save the feature record
            $feature->save();
        }

        // Redirect back with success message
        return redirect()->route('admin.page.index')->with('success', 'Section 3 data has been successfully saved.');
    }

    public function storeSection4(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'FeatureHeading' => 'nullable|max:255',
        ]);

        $banner = Banner::first();

        if(empty($banner))
        {
            $banner =new Banner;
        }
        $banner->FeatureHeading = $request->input('FeatureHeading'); // Save Feature Top Heading




        $banner->save();

        return redirect()->route('admin.page.index')->with('success', 'Section 4 data has been successfully saved.');
    }




}



