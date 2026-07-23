<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CreateCompanyValidationRequest;
use App\Http\Requests\Company\EditCompanyValidationRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    public $industries = [
        'Technology','Finance','Healthcare','Education','Retail',
        'Manufacturing', 'Transportation','Energy','Telecommunications','Hospitality',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();

        // Archived
        if ( $request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);

        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;

        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( CreateCompanyValidationRequest $request)
    {
        $validatedData = $request->validated();
        // dd( $request->all() );

        $companyOwner = User::create([
            'name' => $validatedData['owner_name'],
            'email' => $validatedData['owner_email'],
            'password' => $validatedData['owner_password'],
            'role' => 'company-owner',
        ]);

        if ( !$companyOwner ) {
            return redirect()->route('companies.create')->with('error', 'Failed to create ower!');
        }

        Company::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'industry' => $validatedData['industry'],
            'website' => $validatedData['website'],
            'ownerId' => $companyOwner->id,
        ]);

        return redirect('/companies')->with( ['success' => 'Company created successfully.'] );
    }

    /**
     * Display the specified resource.
     */
    public function show( ?string $id = null )
    {
        if ( $id != null ) {
            $company = Company::findOrFail( $id );
        } else {
            $company = Company::where('ownerId', auth()->user()->id)->first();
        }

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( ?string $id = null)
    {
        $company = $this->getCompany( $id );

        $industries = $this->industries;

        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( EditCompanyValidationRequest $request, ?string $id = null )
    {
        $validatedData = $request->validated();

        $company = $this->getCompany( $id ) ;

        $company->name = $validatedData['name'];
        $company->address = $validatedData['address'];
        $company->industry = $validatedData['industry'];
        $company->website = $validatedData['website'];


        // Update Owner Info
        $companyOwner = $company->owner;
        $companyOwner->name = $validatedData['owner_name'];
        if ( !empty($validatedData['owner_password']) ) {
            $companyOwner->password = $validatedData['owner_password'];
        }

        $companyOwner->save();
        $company->save();

        if ( auth()->user()->isCompanyOwner() ) {
            return redirect()->route('my-company.show')->with( ['success' => 'Your edit has saved successfully.'] );
        }

        if ( $request->input('redirectToList') == 'false' ) {
            return redirect()->route('companies.show', ['company' => $company->id])->with( ['success' => 'Your edit has saved successfully.'] );
        }

        return redirect()->route( 'companies.index' , ['company' => $company->id])->with( ['success' => 'Your edit has saved successfully.'] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail( $id );
        $company->delete();
        return redirect()->route('companies.index')->with( ['success' => 'The company is archived successfully.'] );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => 'true'])->with( ['success' => 'The company is restored successfully.'] );
    }

    // Helper Function - getCompany
    private function getCompany( ?string $id = null ) {
        if ( $id != null ) {
            return $company = Company::findOrFail( $id );
        }
        return $company = Company::where('ownerId', auth()->user()->id)->first();
    }

}
