<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancy\CreateJobVacancyValidationRequest;
use App\Http\Requests\JobVacancy\EditJobVacancyValidationRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    private $jobVacanciesTypes = ['Full-Time', 'Contract', 'Remote', 'Hybrid'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::latest();

        if ( auth()->user()->isCompanyOwner() ) {
            $query->where('companyId', auth()->user()->company->id);
        }

        if( $request->input('archived') == 'true' ) {
            $query->onlyTrashed();
        }

        $vacancies = $query->paginate(10)->onEachSide(1);

        return view('job-vacancy.index', compact('vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        $jobVacanciesTypes = $this->jobVacanciesTypes;

        return view('job-vacancy.create', compact('companies', 'jobCategories', 'jobVacanciesTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobVacancyValidationRequest $request)
    {
        $validatedData = $request->validated();

        // dd( $validatedData );

        JobVacancy::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'salary' => $validatedData['salary'],
            'type' => $validatedData['jobVacancyType'],
            'companyId' => $validatedData['companyId'],
            'jobCategoryId' => $validatedData['jobCategoryId'],
        ]);

        return redirect()->route('job-vacancies.index')->with([ 'success' => 'Job Vcacancy has created successfully' ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vacancy = JobVacancy::findOrFail( $id );

        return view('job-vacancy.show', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail( $id );
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        $jobVacanciesTypes = $this->jobVacanciesTypes;

        return view('job-vacancy.edit', compact('jobVacancy', 'jobVacanciesTypes', 'companies', 'jobCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditJobVacancyValidationRequest $request, string $id)
    {
        $validatedData = $request->validated();

        $jobVacancy = JobVacancy::findOrFail($id);

        $jobVacancy->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'location' => $validatedData['location'],
            'salary' => $validatedData['salary'],
            'type' => $validatedData['jobVacancyType'],
            'companyId' => $validatedData['companyId'],
            'jobCategoryId' => $validatedData['jobCategoryId'],
        ]);

        if ( $request->input('redirectToList') == 'false' ) {
            return redirect()->route('job-vacancies.show', ['job_vacancy' => $jobVacancy->id])->with(['success' => 'Your edit has saved successfully.']);
        }

        return redirect()->route('job-vacancies.index')->with(['success' => 'Job vacancy updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vacancy = JobVacancy::findOrFail( $id );
        $vacancy->delete();

        return redirect()->route('job-vacancies.index')->with([ 'success' => 'Vacancy archived successfully.' ]);
    }

    public function restore(string $id) {
        $vacancy = JobVacancy::onlyTrashed()->findOrFail( $id );
        $vacancy->restore();

        return redirect()->route('job-vacancies.index', ['archived' => 'true'])
                         ->with([ 'success' => 'The company is restored successfully.' ]);
    }
}
