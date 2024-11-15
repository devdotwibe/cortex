<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use App\Models\Exam;
use App\Models\TabOrder;
use App\Trait\ResourceController;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        $tabs1 = TabOrder::orderBy('tab_sort_1', 'asc')->get();

        $tabs2 = TabOrder::orderBy('tab_sort_2', 'asc')->get();

        $tabsctive1 = TabOrder::orderBy('tab_sort_1', 'asc')->first();

        $tabsctive2 = TabOrder::orderBy('tab_sort_2', 'asc')->first();


        // Session::forget('section_tab');

        // Session::forget('section_tab1');
        // Session::forget('section_tab11');



        return view('admin.pages.course',compact('course','tabs1','tabs2','tabsctive1','tabsctive2'));

    }

    public function storesection1(Request $request)
    {

        Session::put("section_tab",'section1-tab');


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
        Session::put("section_tab",'section2-tab');
        Session::put("section_tab1",'tab1');


        $request->validate([
            'logicaltitle1' => 'nullable|string|max:255',
            // 'logicaltitle2' => 'nullable|string|max:255',
            'logicalcontent' => 'nullable|string',
            'logicalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->logicaltitle1 = $request->input('logicaltitle1');
        // $course->logicaltitle2 = $request->input('logicaltitle2');
        $course->logicalcontent = $request->input('logicalcontent');

        if ($request->hasFile('logicalimage')) {
            $logicalImageName = "course/" . $request->file('logicalimage')->hashName();
            Storage::put('course/', $request->file('logicalimage'));
            $course->logicalimage = $logicalImageName;
        }

        $course->save();

        return redirect()->back()->with([
            'success' => 'Tab 1 data has been successfully saved.',
            'tab_1' => true
        ]);


    }

    public function storeTab2(Request $request)
    {


        Session::put("section_tab",'section2-tab');
        Session::put("section_tab1",'tab2');
        // Validate the request data for Tab 2
        $request->validate([
            'criticaltitle1' => 'nullable|string|max:255',
            // 'criticaltitle2' => 'nullable|string|max:255',
            'criticalcontent' => 'nullable|string',
            'criticalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->criticaltitle1 = $request->input('criticaltitle1');
        // $course->criticaltitle2 = $request->input('criticaltitle2');
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


        Session::put("section_tab",'section2-tab');
        Session::put("section_tab1",'tab3');


        // Validate the request data for Tab 3
        $request->validate([
            'abstracttitle1' => 'nullable|string|max:255',
            // 'abstracttitle2' => 'nullable|string|max:255',
            'abstractcontent' => 'nullable|string',
            'abstractimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->abstracttitle1 = $request->input('abstracttitle1');
        // $course->abstracttitle2 = $request->input('abstracttitle2');
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

        Session::put("section_tab",'section2-tab');
        Session::put("section_tab1",'tab4');
        // Validate the request data for Tab 4
        $request->validate([
            'numericaltitle1' => 'nullable|string|max:255',
            // 'numericaltitle2' => 'nullable|string|max:255',
            'numericalcontent' => 'nullable|string',
            'numericalimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',
        ]);

        $course = Courses::first();

        if(empty($course))
        {
            $course =new Courses;
        }

        $course->numericaltitle1 = $request->input('numericaltitle1');
        // $course->numericaltitle2 = $request->input('numericaltitle2');
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

        Session::put("section_tab",'section3-tab');
        Session::put("section_tab11",'sec_tab1');
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

        Session::put("section_tab",'section3-tab');
        Session::put("section_tab11",'sec_tab2');
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





        Session::put("section_tab",'section3-tab');
        Session::put("section_tab11",'sec_tab3');
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

        Session::put("section_tab",'section3-tab');
        Session::put("section_tab11",'sec_tab4');
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






    public function storesection4(Request $request)
    {

        Session::put("section_tab",'section2-tab');


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


    public function storesection5(Request $request)
    {

        Session::put("section_tab",'section5-tab');
        // Validate the request data for Section 1
        $request->validate([
            'privatecontent' => 'required|nullable|string|',


            // 'image' => 'nullable|image|max:2048', // Validate image
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,bmp,webp,svg|max:2048',

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

        return redirect()->route('admin.course.index')->with('success', 'Section 4 data has been successfully saved.');
    }



    public function deleteImage()
    {
        $course = Courses::first();
    
        if ($course && $course->image) {
            if (Storage::exists($course->image)) {
                Storage::delete($course->image);
            }
    
            // Set image to null and save the change
            $course->image = null;
            $course->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404);
    }
    


public function deletePrivateImage()
{
    // Fetch the first course record (adjust this based on your needs if it should be fetched by ID)
    $course = Courses::first();

    if ($course && $course->privateimage) {
        // Check if the private image file exists in the storage
        if (Storage::exists($course->privateimage)) {
            // Delete the private image from the storage
            Storage::delete($course->privateimage);
        }

        // Set the privateimage field to null in the database
        $course->privateimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the private image was not found
    return response()->json(['success' => false], 404);
}


public function deleteLogicalImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->logicalimage) {
        // Check if the logical image file exists in the storage
        if (Storage::exists($course->logicalimage)) {
            // Delete the logical image from the storage
            Storage::delete($course->logicalimage);
        }

        // Set the logicalimage field to null in the database
        $course->logicalimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the logical image was not found
    return response()->json(['success' => false], 404);
}


public function deleteCriticalImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->criticalimage) {
        // Check if the critical image file exists in the storage
        if (Storage::exists($course->criticalimage)) {
            // Delete the critical image from the storage
            Storage::delete($course->criticalimage);
        }

        // Set the criticalimage field to null in the database
        $course->criticalimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the critical image was not found
    return response()->json(['success' => false], 404);
}



public function deleteAbstractImage()
{
    $course = Courses::first();

    if ($course && $course->abstractimage) {
        // Check if the abstract image file exists in the storage
        if (Storage::exists($course->abstractimage)) {
            // Delete the abstract image from the storage
            Storage::delete($course->abstractimage);
        }

        // Set the abstractimage field to null in the database
        $course->abstractimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the abstract image was not found
    return response()->json(['success' => false], 404);
}



public function deleteNumericalImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->numericalimage) {
        // Check if the numerical image file exists in the storage
        if (Storage::exists($course->numericalimage)) {
            // Delete the numerical image from the storage
            Storage::delete($course->numericalimage);
        }

        // Set the numericalimage field to null in the database
        $course->numericalimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the numerical image was not found
    return response()->json(['success' => false], 404);
}


public function deleteLearnImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->learnimage) {
        // Check if the learn image file exists in the storage
        if (Storage::exists($course->learnimage)) {
            // Delete the learn image from the storage
            Storage::delete($course->learnimage);
        }

        // Set the learnimage field to null in the database
        $course->learnimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the learn image was not found
    return response()->json(['success' => false], 404);
}

public function deleteQuestionBankImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->questionbankimage) {
        // Check if the question bank image file exists in the storage
        if (Storage::exists($course->questionbankimage)) {
            // Delete the question bank image from the storage
            Storage::delete($course->questionbankimage);
        }

        // Set the questionbankimage field to null in the database
        $course->questionbankimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the question bank image was not found
    return response()->json(['success' => false], 404);
}

public function deleteTopicImage()
{
    // Find the course by ID
    $course = Courses::first();

    if ($course && $course->topicimage) {
        // Check if the topic image file exists in the storage
        if (Storage::exists($course->topicimage)) {
            // Delete the topic image from the storage
            Storage::delete($course->topicimage);
        }

        // Set the topicimage field to null in the database
        $course->topicimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the topic image was not found
    return response()->json(['success' => false], 404);
}
public function deleteFullmockImage()
{
    // Find the course by ID
    $course = Courses::first();


    if ($course && $course->fullmockimage) {
        // Check if the fullmock image file exists in the storage
        if (Storage::exists($course->fullmockimage)) {
            // Delete the fullmock image from the storage
            Storage::delete($course->fullmockimage);
        }

        // Set the fullmockimage field to null in the database
        $course->fullmockimage = null;
        $course->save();

        // Return a success response
        return response()->json(['success' => true]);
    }

    // Return a failure response if the fullmock image was not found
    return response()->json(['success' => false], 404);
}



    public function tabchange(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $tabId) {

            $taborder = TabOrder::where('tab_id_1',$tabId)->first();

            if ($taborder) {

                $taborder->tab_sort_1 = $index + 1;

                $taborder->save();
            }

        }

        return response()->json(['success' => true]);
    }








    public function tabchange1(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $index => $tabId) {

            $taborder = TabOrder::where('tab_id_2',$tabId)->first();

            if ($taborder) {

                $taborder->tab_sort_2 = $index + 1;

                $taborder->save();
            }

        }

        return response()->json(['success' => true]);
    }






}
