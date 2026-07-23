<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplication\EditJobApplicationValidationRequest;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::latest();

        if ( auth()->user()->isCompanyOwner() ) {
            $query->whereHas('jobVacancy', function( $query )  {
                $query->where('companyId', auth()->user()->company->id);
            });
        }

        if( $request->input('archived') == 'true' ) {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(10)->onEachSide(1);

        return view('job-application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail( $id );

        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail( $id );

        $jobApplicationStatuses = ['pending', 'accepted', 'rejected'];

        return view('job-application.edit', compact('jobApplication', 'jobApplicationStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditJobApplicationValidationRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $jobApplication = JobApplication::findOrFail( $id );

        $jobApplication->update([
            'status' => $validatedData['status'],
        ]);

        if ( $request->input('redirectToList') == 'false' ) {
            return redirect()->route('job-applications.show', ['job_application' => $jobApplication->id])->with(['success' => 'Your edit has saved successfully.']);
        }

        return redirect()->route('job-applications.index')->with([ 'success' => 'Job application updated successfully.' ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vacancy = JobApplication::findOrFail( $id );
        $vacancy->delete();

        return redirect()->route('job-applications.index')->with([ 'success' => 'Job application archived successfully.' ]);
    }

    public function restore(string $id) {
        $vacancy = JobApplication::onlyTrashed()->findOrFail( $id );
        $vacancy->restore();

        return redirect()->route('job-applications.index', ['archived' => 'true'])
                         ->with([ 'success' => 'The application is restored successfully.' ]);
    }
}
