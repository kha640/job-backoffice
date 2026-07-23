<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create Admin
        User::firstOrCreate([
            'email' => 'admin@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Seed Data To Test With
        $jobData = json_decode( file_get_contents( database_path('data/job_data.json') ) , true);
        $jobApplicationsData = json_decode( file_get_contents( database_path('data/job_applications.json') ) , true);

        // Create Job Categories
        foreach( $jobData['jobCategories'] as $category ) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        };

        // create companies
        foreach( $jobData['companies'] as $company ) {
            // Create Company Owner
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('password'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'ownerId' => $companyOwner->id,
            ]);
        };

        // Create Job Vacancies
        foreach( $jobData['jobVacancies'] as $vacancy ) {
            // Get The Created Company
            $company = Company::where('name', $vacancy['company'])->firstOrFail();

            //Get The Created Ctegory
            $category = JobCategory::where('name', $vacancy['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $vacancy['title'],
                'companyId' => $company->id,
            ], [
                'description' => $vacancy['description'],
                'location' => $vacancy['location'],
                'salary' => $vacancy['salary'],
                'type' => $vacancy['type'],
                'jobCategoryId' => $category->id,
            ]);
        }


        // Create Job Application
        foreach( $jobApplicationsData['jobApplications'] as $application ) {
            // Get Random Job Vacancy -- بجيب من الموجودين
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // Create Applicant (Job Seeker)
            $applicant = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(),
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('password'),
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            // Create Resume
            $resume = Resume::create([
                'userId' => $applicant->id,
                'fileName' => $application['resume']['filename'],
                'fileUri' => $application['resume']['fileUri'],
                'contactDetails' => $application['resume']['contactDetails'],
                'summary' => $application['resume']['summary'],
                'skills' => $application['resume']['skills'],
                'experience' => $application['resume']['experience'],
                'education' => $application['resume']['education'],
            ]);

            // Create Job Application
            JobApplication::create([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
                'status' => $application['status'],
                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
            ]);
        }
    }
}
