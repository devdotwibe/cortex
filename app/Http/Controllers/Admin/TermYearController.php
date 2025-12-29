<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TermYearController extends Controller
{
   function index(Request $request)
    {
        if ($request->ajax()) {

            $term_year = TermYear::where('id','>',0);

            return DataTables::of($term_year)

                ->addColumn('action', function ($row) {

                    return '<button class="btn btn-sm btn-primary edit-btn" data-id="' . $row->id . '">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">Delete</button>';

                })

                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.term_year.index');

    }

    public function store(Request $request)
    {
        $request->validate([
            'year_name' => 'required|string|max:255'
        ]);

        TermYear::create($request->only('year_name'));

        return response()->json(['message' => 'Term Year added successfully']);
    }

    public function edit($id)
    {
        return TermYear::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'year_name' => 'required|string|max:255'
        ]);

        TermYear::findOrFail($id)->update($request->only('year_name'));

        return response()->json(['message' => 'Term Year updated successfully']);
    }

    public function destroy($id)
    {
        TermYear::findOrFail($id)->delete();

        return response()->json(['message' => 'Term Year deleted successfully']);
    }

}
