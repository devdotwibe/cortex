<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\Exam;
use App\Trait\ResourceController;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;


class CourseController extends Controller
{

    use ResourceController;

    function __construct()
    {
        self::$model=Exam::class;
        self::$routeName="admin.course";
    }

    public function index(Request $request)
    {


        $course = Courses::first();

        return view('admin.pages.course',compact('course'));

    }

    public function storesection1(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'heading' => 'required|nullable|string|max:255',
            'buttonlabel' => 'required|string|max:255',
            'buttonlink' => 'required|string',


            // 'image' => 'nullable|image|max:2048', // Validate image
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',

        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->heading = $request->input('heading');
        $course->buttonlabel = $request->input('buttonlabel');
        $course->buttonlink = $request->input('buttonlink');




        if ($request->hasFile('image')) {
            $imageName = "course/" . $request->file('image')->hashName();
            Storage::put('course', $request->file('image'));

            $course->image = $imageName;
        }



        $course->save();

        return redirect()->route('admin.course.index')->with('success', 'Section 1 data has been successfully saved.');
    }


    public function storeTab1(Request $request)
    {
        // Validate the request data for Tab 1
        $request->validate([
            'logicaltitle1' => 'nullable|string|max:255',
            'logicaltitle2' => 'nullable|string|max:255',
            'logicalcontent' => 'nullable|string',
            'logicalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->logicaltitle1 = $request->input('logicaltitle1');
        $course->logicaltitle2 = $request->input('logicaltitle2');
        $course->logicalcontent = $request->input('logicalcontent');

        if ($request->hasFile('logicalimage')) {
            $logicalImageName = "course/" . $request->file('logicalimage')->hashName();
            Storage::put('course/', $request->file('logicalimage'));
            $course->logicalimage = $logicalImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 1 data has been successfully saved.');
    }

    public function storeTab2(Request $request)
    {
        // Validate the request data for Tab 2
        $request->validate([
            'criticaltitle1' => 'nullable|string|max:255',
            'criticaltitle2' => 'nullable|string|max:255',
            'criticalcontent' => 'nullable|string',
            'criticalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->criticaltitle1 = $request->input('criticaltitle1');
        $course->criticaltitle2 = $request->input('criticaltitle2');
        $course->criticalcontent = $request->input('criticalcontent');

        if ($request->hasFile('criticalimage')) {
            $criticalImageName = "course/" . $request->file('criticalimage')->hashName();
            Storage::put('course/', $request->file('criticalimage'));
            $course->criticalimage = $criticalImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 2 data has been successfully saved.');
    }

    public function storeTab3(Request $request)
    {
        // Validate the request data for Tab 3
        $request->validate([
            'abstracttitle1' => 'nullable|string|max:255',
            'abstracttitle2' => 'nullable|string|max:255',
            'abstractcontent' => 'nullable|string',
            'abstractimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->abstracttitle1 = $request->input('abstracttitle1');
        $course->abstracttitle2 = $request->input('abstracttitle2');
        $course->abstractcontent = $request->input('abstractcontent');

        if ($request->hasFile('abstractimage')) {
            $abstractImageName = "course/" . $request->file('abstractimage')->hashName();
            Storage::put('course/', $request->file('abstractimage'));
            $course->abstractimage = $abstractImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 3 data has been successfully saved.');
    }

    public function storeTab4(Request $request)
    {
        // Validate the request data for Tab 4
        $request->validate([
            'numericaltitle1' => 'nullable|string|max:255',
            'numericaltitle2' => 'nullable|string|max:255',
            'numericalcontent' => 'nullable|string',
            'numericalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->numericaltitle1 = $request->input('numericaltitle1');
        $course->numericaltitle2 = $request->input('numericaltitle2');
        $course->numericalcontent = $request->input('numericalcontent');

        if ($request->hasFile('numericalimage')) {
            $numericalImageName = "course/" . $request->file('numericalimage')->hashName();
            Storage::put('course/', $request->file('numericalimage'));
            $course->numericalimage = $numericalImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 4 data has been successfully saved.');
    }





    public function storeSection3Tab1(Request $request)
    {
        $request->validate([
            'learncontent' => 'nullable|string',
            'learnimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->learncontent = $request->input('learncontent');

        if ($request->hasFile('learnimage')) {
            $learnImageName = "course/" . $request->file('learnimage')->hashName();
            Storage::put('course/', $request->file('learnimage'));
            $course->learnimage = $learnImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 1 data has been successfully saved.');
    }

    // Store for tab 2 (Question Bank)
    public function storeSection3Tab2(Request $request)
    {
        $request->validate([
            'questionbankcontent' => 'nullable|string',
            'questionbankimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->questionbankcontent = $request->input('questionbankcontent');

        if ($request->hasFile('questionbankimage')) {
            $questionBankImageName = "course/" . $request->file('questionbankimage')->hashName();
            Storage::put('course/', $request->file('questionbankimage'));
            $course->questionbankimage = $questionBankImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 2 data has been successfully saved.');
    }

    // Store for tab 3 (Topic)
    public function storeSection3Tab3(Request $request)
    {
        $request->validate([
            'topiccontent' => 'nullable|string',
            'topicimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->topiccontent = $request->input('topiccontent');

        if ($request->hasFile('topicimage')) {
            $topicImageName = "course/" . $request->file('topicimage')->hashName();
            Storage::put('course/', $request->file('topicimage'));
            $course->topicimage = $topicImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 3 data has been successfully saved.');
    }

    // Store for tab 4 (Full Mock)
    public function storeSection3Tab4(Request $request)
    {
        $request->validate([
            'fullmockcontent' => 'nullable|string',
            'fullmockimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->fullmockcontent = $request->input('fullmockcontent');

        if ($request->hasFile('fullmockimage')) {
            $fullMockImageName = "course/" . $request->file('fullmockimage')->hashName();
            Storage::put('course/', $request->file('fullmockimage'));
            $course->fullmockimage = $fullMockImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 4 data has been successfully saved.');
    }

    // Store for tab 5 (Private Content)
    public function storeSection3Tab5(Request $request)
    {
        $request->validate([
            'privatecontent' => 'nullable|string',
            'privateimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->privatecontent = $request->input('privatecontent');

        if ($request->hasFile('privateimage')) {
            $privateImageName = "course/" . $request->file('privateimage')->hashName();
            Storage::put('course/', $request->file('privateimage'));
            $course->privateimage = $privateImageName;
        }

        $course->save();

        return redirect()->back()->with('success', 'Tab 5 data has been successfully saved.');
    }





    public function storesection4(Request $request)
    {
        // Validate the request data for Section 1
        $request->validate([
            'coursetitle' => 'nullable|string|max:255',





        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->coursetitle = $request->input('coursetitle');





        $course->save();

        return redirect()->route('admin.course.index')->with('success', 'Section 2 data has been successfully saved.');
    }



}
