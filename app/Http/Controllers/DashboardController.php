<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        /*
        الوير نال ممكن تتشال لان لارفيل ديفولت بياخد في الاعتبار دا
        وبيجيب فقط الاكتف وليس الديليتيد
        لكن الافضل اني اسيبها عشان اوضح في الكتابه واكون ستركت اكتر
        وكمان عشان لو حصل اي تغغير في الفريمم وورك في النقطة دي
        اكون تمام ومحتاجش اغير - رغم صعوبة حاجه زي دي
        */

        /*
        لما اطبق معادلات رياضيه لازم اعملها عن طريق الداتا بيز
        عن طريق الكويرز حتى لو كانت كومبلكس شويه
        عشان دا اسرع بكتير جدا ةخيكون اخف على الاب بتاعي والسرعه
        لان كدا كدا الداتا بيز انجن قوي جدا وهيعملها احسن

        يعني الداتا اللي تجيلي تكون
        */

    public function index() {
        if ( auth()->user()->isAdmin() ) {
            $analytics = $this->adminDashboard();
        } else {
            $analytics = $this->companyOwnerDashboard();
        }

        return view('dashboard.index',compact('analytics'));
    }

    // Admin Dashboard Function
    public function adminDashboard() :array
    {
        // Active Users At Last 30 Days
        $totalActiveUsersAtLastOneMonth =  User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')->count();

        // Total Active Job Vacancies
        $totalActiveJobVacancies = JobVacancy::whereNull('deleted_at')->count();

        // Total Active Applicationa
        $totalActiveApplications = JobApplication::whereNull('deleted_at')->count();


        // Most Applied Jobs
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->orderByDesc('totalCount')->limit(5)->get();


        // Conversion Rate
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map( function( $job ) {
                if ( $job->viewCount > 0 ) {
                    $job->conversionRate = round( ($job->totalCount / $job->viewCount) * 100, 2 ) ;
                } else {
                    $job->conversionRate = 0;
                }

                return $job;
            } );

        $analytics = [
            'totalActiveUsersAtLastOneMonth'=> $totalActiveUsersAtLastOneMonth,
            'totalActiveJobVacancies' => $totalActiveJobVacancies,
            'totalActiveApplications' => $totalActiveApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];

        return $analytics;
    }

    // Company Owner Dashoard Function
    public function companyOwnerDashboard() {

        $company = auth()->user()->company;

        // Filter Active Users By Applying To Jobs Of The Company
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function( $query ) use ( $company ) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })
            ->count();

        // Total Jobs Of The Comapny
        $totalJobs = $company->jobVacancies->count();

        // Total Applications Of The Company
        $totalApplications = JobApplication::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();


        // Most Applied Jobs Of The Company
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id', $company->jobVacancieS->pluck('id'))
            ->limit(5)
            ->orderByDesc('totalCount')
            ->get();

        // Conversion Rates
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
            ->whereIn('id', $company->jobVacancies->pluck('id'))
            ->having('totalCount', '>', 0)
            ->orderByDesc('totalCount')
            ->limit(5)
            ->get()
            ->map( function( $job ) {
                if ( $job->viewCount > 0 ) {
                    $job->conversionRate = round( ($job->totalCount / $job->viewCount) * 100, 2 ) ;
                } else {
                    $job->conversionRate = 0;
                }

                return $job;
            } );


        return $analytics = [
            'totalActiveUsersAtLastOneMonth'=> $activeUsers,
            'totalActiveJobVacancies' => $totalJobs,
            'totalActiveApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];
    }
}
