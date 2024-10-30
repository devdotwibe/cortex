<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hashtag;
use Yajra\DataTables\Facades\DataTables;

class HashtagController extends Controller
{
    /**
     * Display the hashtag management view.
     *
     * @return \Illuminate\View\View
     */
    public function hashtags()
    {
        return view('admin.community.hashtags'); 
    }

    /**
     * Fetch and return all hashtags for DataTables.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch all hashtags ordered by ID
            $hashtags = Hashtag::orderBy('id', 'asc');

            return DataTables::of($hashtags)
                ->addColumn('action', function ($data) {
                    return
                        '<a onclick="editHashtag('."'".route('admin.community.hashtags.edit', $data->id)."'".')" class="btn btn-icons edit_btn">
                            <span class="adminside-icon">
                                <img src="'.asset('assets/images/icons/iconamoon_edit.svg').'" alt="Edit">
                            </span>
                            <span class="adminactive-icon">
                                <img src="'.asset('assets/images/iconshover/iconamoon_edit-yellow.svg').'" alt="Edit Active">
                            </span>
                        </a>' .
                        '<a onclick="deleteHashtag('."'".route('admin.community.hashtags.destroy', $data->id)."'".')" class="btn btn-icons delete_btn">
                            <span class="adminside-icon">
                                <img src="' . asset("assets/images/icons/material-symbols_delete-outline.svg") . '" alt="Delete">
                            </span>
                            <span class="adminactive-icon">
                                <img src="' . asset("assets/images/iconshover/material-symbols_delete-yellow.svg") . '" alt="Delete Active">
                            </span>
                        </a>';
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.community.hashtags'); // Ensure this view exists
    }

    /**
     * Store a newly created hashtag in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255', // Ensure this matches the input field name
        ]);

        try {
            // Create the hashtag
            Hashtag::create($request->all());
            return redirect()->route('admin.community.hashtags')->with('success', 'Hashtag created successfully.');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->back()->withErrors(['error' => 'Failed to create hashtag: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified hashtag.
     *
     * @param Hashtag $hashtag
     * @return \Illuminate\View\View
     */
    public function edit(Hashtag $hashtag)
    {
        return view('admin.community.hashtags.edit', compact('hashtag')); // Edit view
    }

    /**
     * Update the specified hashtag in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param Hashtag $hashtag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Hashtag $hashtag)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $hashtag->update($request->all());
            return redirect()->route('admin.community.hashtags')->with('success', 'Hashtag updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update hashtag: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified hashtag from the database.
     *
     * @param Hashtag $hashtag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Hashtag $hashtag)
    {
        try {
            $hashtag->delete();
            return redirect()->route('admin.community.hashtags')->with('success', 'Hashtag deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete hashtag: ' . $e->getMessage()]);
        }
    }
}
