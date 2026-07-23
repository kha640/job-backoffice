<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Company: ' . $company->name }}
        </h2>
    </x-slot>

    {{-- Back button --}}
    @if ( auth()->user()->isAdmin() )
        <div class="mt-5 ml-6">
            <a href="{{ route('companies.index') }}" class="text-lg p-2 bg-gray-200 hover:bg-gray-300 rounded">
                &larr; Back
            </a>
        </div>
    @endif


    <div class="overflow-x-auto p-6 ">

        {{-- Success Message --}}
        <x-toast-notification/>

        {{-- Company Details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow ">
            <div class="space-y-2">
                <h3 class="text-2xl font-bold text-blue-600"> Company Details </h3>
                <p> <strong class="border-b-2 border-blue-500"> Owner Name:</strong> {{ $company->owner->name }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Owner Email:</strong> {{ $company->owner->email }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Name:</strong> {{ $company->name }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Address:</strong> {{ $company->address }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Industry:</strong> {{ $company->industry }} </p>
                <p>
                    <strong class="border-b-2 border-blue-500"> Website</strong> :
                    <a class="text-blue-500 hover:text-blue-700 underline" target="_blank" href="{{ $company->website }}">
                        {{ $company->website }}
                    </a>
                </p>
            </div>

            {{-- Edit And Archive Buttons --}}
            <div class="mt-4 flex space-x-4 justify-end">
                @if ( auth()->user()->isAdmin() )
                    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false' ]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @else
                    <a href="{{ route('my-company.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endif


                @if ( auth()->user()->isAdmin() )
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Archive
                        </button>
                    </form>
                @endif
            </div>

            {{-- Tabs Navigation: Jobs, Applications --}}
            @if ( auth()->user()->isAdmin() )
                <div class="mt-6">
                    <nav class="flex space-x-4">
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                        class="{{ (request('tab') == 'jobs' || request('tab') == '') ? 'border-b-2 border-blue-500' : '' }} py-2 px-4 text-sm font-semibold">
                            Jobs
                        </a>
                        <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                        class="{{ request('tab') === 'applications' ? 'border-b-2 border-blue-500' : '' }} py-2 px-4 text-sm font-semibold">
                            Applications
                        </a>
                    </nav>
                </div>

                {{-- Tab Content --}}
                <div class="mt-6">
                    {{-- Jobs Tab --}}
                    <div class="{{ (request('tab') == 'jobs' || request('tab') == '') ? 'block' : 'hidden' }}">
                        <table class="min-w-full  rounded-lg shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600"> Title </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Type </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Location </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Salary </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $company->jobVacancies as $job )
                                    <tr class="border-b ">
                                        <td class="px-6 py-3 "> {{ $job->title }} </td>
                                        <td class="px-6 py-3 "> {{ $job->type }} </td>
                                        <td class="px-6 py-3 "> {{ $job->location }} </td>
                                        <td class="px-6 py-3 "> {{ $job->salary }} </td>
                                        <td class="px-6 py-3  ">
                                            <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 hover:text-blue-700 ">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-3 text-gray-800 text-center"> No jobs found for this company. </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Applications Tab --}}
                    <div id="applications" class="{{ request('tab') === 'applications' ? 'block' : 'hidden' }}">
                        <table class="min-w-full  rounded-lg shadow">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600"> Title </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Applicant Name </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Email </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Status </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $company->jobApplications as $application )
                                    <tr class="border-b ">
                                        <td class="px-6 py-3 "> {{ $application->jobVacancy->title }} </td>
                                        <td class="px-6 py-3 "> {{ $application->user->name }} </td>
                                        <td class="px-6 py-3 "> {{ $application->user->email }} </td>
                                        <td class="px-6 py-3 "> {{ $application->status }} </td>
                                        <td class="px-6 py-3  ">
                                            <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 ">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-3 text-gray-800 text-center"> No applications found for this company. </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
