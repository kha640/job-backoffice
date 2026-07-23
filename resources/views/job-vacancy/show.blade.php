<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $vacancy->title }}
        </h2>
    </x-slot>

    {{-- Back button --}}
    <div class="mt-5 ml-6">
        <a href="{{ route('job-vacancies.index') }}" class="text-lg p-2 bg-gray-200 hover:bg-gray-300 rounded">
            &larr; Back
        </a>
    </div>

    <div class="overflow-x-auto p-6 ">
        {{-- Company Details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow ">
            <div class="space-y-2">
                <h3 class="text-2xl font-bold text-blue-600"> Job Vacancy Details </h3>
                <p> <strong class="border-b-2 border-blue-500"> Title:</strong> {{ $vacancy->title }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Description:</strong> {{ $vacancy->description }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Location:</strong> {{ $vacancy->location }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Salary:</strong> ${{ number_format($vacancy->salary, 2) }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Type:</strong> {{ $vacancy->type }} </p>
                <a href="{{ route('companies.show', $vacancy->company->id) }}">
                    <strong class="border-b-2 border-blue-500"> Company Name:</strong>
                    <span class="text-blue-500 hover:text-blue-700 hover:underline"> {{ $vacancy->company->name }} </span>
                </a>
            </div>

            {{-- Edit And Archive Buttons --}}
            <div class="mt-4 flex space-x-4 justify-end">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $vacancy->id, 'redirectToList' => 'false']) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Archive
                    </button>
                </form>
            </div>

            {{-- Tabs Navigation: Jobs, Applications --}}
            <div class="mt-6">
                <nav class="flex space-x-4">
                    <a href="{{ route('job-vacancies.show', ['job_vacancy' => $vacancy->id, 'tab' => 'applications']) }}"
                       class="{{ ( request('tab') === 'applications' || request('tab') == '' ) ? 'border-b-2 border-blue-500' : '' }} py-2 px-4 text-sm font-semibold">
                        Applications
                    </a>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="mt-6">
                {{-- Applications Tab --}}
                <div id="applications" class="{{ ( request('tab') == 'applications' || request('tab') == '' ) ? 'block' : 'hidden' }}">
                    <table class="min-w-full  rounded-lg shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Applicant Name </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Job Title </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Status </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $vacancy->jobApplications as $application )
                                <tr class="border-b ">
                                    <td class="px-6 py-3 "> {{ $application->user->name }} </td>
                                    <td class="px-6 py-3 "> {{ $application->jobVacancy->title }} </td>
                                    <td class="px-6 py-3 "> {{ $application->status }} </td>
                                    <td class="px-6 py-3  ">
                                        <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 hover:text-blue-700 ">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-3 text-gray-800 text-center"> No applications found for this vacancy. </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>



    </div>

</x-app-layout>
