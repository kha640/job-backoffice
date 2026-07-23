<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied to {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    {{-- Back button --}}
    <div class="mt-5 ml-6">
        <a href="{{ route('job-applications.index') }}" class="text-lg p-2 bg-gray-200 hover:bg-gray-300 rounded">
            &larr; Back
        </a>
    </div>

    <div class="overflow-x-auto p-6 ">
        {{-- Application Details --}}
        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow ">
            <div class="space-y-2">
                <h3 class="text-2xl font-bold text-blue-600"> Application Details </h3>
                <p> <strong class="border-b-2 border-blue-500"> Applicant Name:</strong> {{ $jobApplication->user->name }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Company:</strong> {{ $jobApplication->jobVacancy->company->name }} </p>
                <p> <strong class="border-b-2 border-blue-500"> Status:</strong>
                    <span class="@if($jobApplication->status == 'accepted') text-green-500 @elseif($jobApplication->status == 'rejected') text-red-500 @elseif($jobApplication->status == 'pending') text-purple-500 @endif">
                        {{ $jobApplication->status }}
                    </span>
                </p>
                <p>
                    <strong class="border-b-2 border-blue-500"> Resume</strong> :
                    <a class="text-blue-500 hover:text-blue-700 underline" target="_blank" href="{{ $jobApplication->resume->fileUri }}">
                        {{ $jobApplication->resume->fileUri }}
                    </a>    
                </p>
            </div>

            {{-- Edit And Archive Buttons --}}
            <div class="mt-4 flex space-x-4 justify-end">
                <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false' ]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Archive
                    </button>
                </form>
            </div>

            {{-- Tabs Navigation: Resume, AI Feedback --}}
            <div class="mt-6">
                <nav class="flex space-x-4">
                    <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                       class="{{ (request('tab') == 'resume' || request('tab') == '') ? 'border-b-2 border-blue-500' : '' }} py-2 px-4 text-sm font-semibold">
                        Resume
                    </a>
                    <a href="{{ route('job-applications.show', ['job_application' => $jobApplication->id, 'tab' => 'AiFeedback']) }}"
                       class="{{ request('tab') === 'AiFeedback' ? 'border-b-2 border-blue-500' : '' }} py-2 px-4 text-sm font-semibold">
                        AI Feedback
                    </a>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="mt-6">
                {{-- Rsume Tab --}}
                <div class="{{ (request('tab') == 'resume' || request('tab') == '') ? 'block' : 'hidden' }}">
                    <table class="min-w-full  rounded-lg shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600"> Summray </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Skills </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Experience </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Education </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b ">
                                <td class="px-6 py-3 "> {{ $jobApplication->resume->summary }} </td>
                                <td class="px-6 py-3 "> {{ $jobApplication->resume->skills }} </td>
                                <td class="px-6 py-3 "> {{ $jobApplication->resume->experience }} </td>
                                <td class="px-6 py-3 "> {{ $jobApplication->resume->education }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- AI Feedback Tab --}}
                <div id="AiFeedback" class="{{ request('tab') === 'AiFeedback' ? 'block' : 'hidden' }}">
                    <table class="min-w-full  rounded-lg shadow">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600"> AI Score </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> AI Feedback </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b ">
                                <td class="px-6 py-3 "> {{ $jobApplication->aiGeneratedScore }} </td>
                                <td class="px-6 py-3 "> {{ $jobApplication->aiGeneratedFeedback }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
