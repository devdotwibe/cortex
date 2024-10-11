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
            'count' => 'nullable',
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
        return redirect()->back()->with('success', 'Timetable added successfully!');
    }
    
}    