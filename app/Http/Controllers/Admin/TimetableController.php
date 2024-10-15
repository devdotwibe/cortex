<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Timetable;
use App\Trait\ResourceController;
use Yajra\DataTables\Facades\DataTables;

class TimetableController extends Controller
{
    public function index()
    {
        // Retrieve all timetable records from the database
        $timetables = Timetable::all();
dd($timetables);
        // Return the view with timetable data
        return view('admin.live-class.index', compact('timetables'));
    }

    // Store a new timetable in the database
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'starttime' => 'required',
            'endtime' => 'required',
            'day' => 'required',
            'count' => 'required',
            'starttime_am_pm' => 'required', // Validate AM/PM for start time
            'endtime_am_pm' => 'required',   // Validate AM/PM for end time
        ]);
    
         // Combine starttime, endtime, and day for the 'classtime' field
         $classtime = $request->starttime . ' - ' . $request->endtime . ' on ' . $request->day;

   
    
        // Create a new Timetable entry in the database
        Timetable::create([
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'starttime_am_pm' =>$request->starttime_am_pm,
            'endtime_am_pm' =>$request->endtime_am_pm,
            'day' => $request->day,
            'classtime' => $classtime,
            'count' => $request->count,
        ]);
    
        // Redirect back with a success message
        
        return redirect()->back()->with('create_timetable', 'Timetable added successfully!');
        
    }



    public function edit($id)
{
    $timetable = Timetable::findOrFail($id);
    return view('admin.timetable.edit', compact('timetable'));
}

public function update(Request $request, $id)
{
    $timetable = Timetable::findOrFail($id);
    $timetable->update($request->all()); // validate input as needed
    return redirect()->route('create_timetable')->with('success', 'Timetable updated successfully');
}

public function destroy($id)
{
    $timetable = Timetable::findOrFail($id);
    $timetable->delete();
    return redirect()->route('create_timetable')->with('success', 'Timetable deleted successfully');
}


public function fetcheditdata($id)
{
    $timetable = Timetable::findOrFail($id);

    return response()->json($timetable);
}




    
}    