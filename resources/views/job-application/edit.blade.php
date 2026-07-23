<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-4  bg-white rounded-lg shadow-md">
            <form action="{{ route('job-applications.update', ['job_application' => $jobApplication->id, 'redirectToList' => request('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Job Application Details --}}
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold"> Job Applicant Details </h3>

                    {{-- Applicant Name --}}
                    <div class="mb-3">
                        <label for="applicantName" class="block text-gray-700 mb-1">Applicant Name: </label>
                        <span class="font-bold"> {{ $jobApplication->user->name }} </span>
                    </div>

                    {{-- Job Vacancy --}}
                    <div class="mb-3">
                        <label for="jobVacancy" class="block text-gray-700 mb-1">Job Vacancy</label>
                        <span class="font-bold"> {{ $jobApplication->jobVacancy->title }} </span>
                    </div>

                    {{-- Company --}}
                    <div class="mb-3">
                        <label for="company" class="block text-gray-700 mb-2">Company</label>
                        <span class="font-bold"> {{ $jobApplication->jobVacancy->company->name }} </span>
                    </div>

                    {{-- AI Generated Score --}}
                    <div class="mb-3">
                        <label class="block text-gray-700 mb-1">AI Generatd Score</label>
                        <span class="font-bold"> {{ $jobApplication->aiGeneratedScore }} </span>
                    </div>
                    {{-- AI Generated Feedback --}}

                    <div class="mb-3">
                        <label class="block text-gray-700 mb-1">AI Generatd Feedback</label>
                        <span class="font-bold"> {{ $jobApplication->aiGeneratedFeedback }} </span>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="block text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class=" {{ $errors->has('status') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                            @foreach ( $jobApplicationStatuses as $jobApplicationStatus )
                                <option value="{{ $jobApplicationStatus }}" {{ old('status', $jobApplication->status) == $jobApplicationStatus ? 'selected' : '' }}> {{ $jobApplicationStatus }} </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Add, Cancel Buttons --}}
                <div class="mt-2 flex items-center justify-end">
                    <a href="{{ route('job-applications.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Applicant Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
