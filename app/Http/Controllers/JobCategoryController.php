<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategory\CreateJobCategoryValidationRequest;
use App\Http\Requests\JobCategory\EditJobCategoryValidationRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobCategory::latest();

        // Archived
        if ( $request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $categories = $query->paginate(10)->onEachSide(1);

        return view('job-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobCategoryValidationRequest $request)
    {
        $validatedData = $request->validated();

        JobCategory::create($validatedData);

        return redirect('/job-categories')->with( ['success' => 'Categore created successfully.'] );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);

        return view('job-category.edit', compact('jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditJobCategoryValidationRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $jobCategory = JobCategory::findOrFail( $id );

        $jobCategory->name = $validatedData['name'];

        $jobCategory->save();

        return redirect('/job-categories')->with( ['success' => 'Your edit has saved successfully.'] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobCategory = JobCategory::findOrFail( $id );
        $jobCategory->delete();
        return redirect()->route('job-categories.index')->with( ['success' => 'The category is archived successfully.'] );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobCategory = JobCategory::onlyTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()->route('job-categories.index', ['archived' => 'true'])->with( ['success' => 'The category is restored successfully.'] );
    }
}
