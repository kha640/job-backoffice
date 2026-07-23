<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-4  bg-white rounded-lg shadow-md">
            <form action="{{ route('job-vacancies.update', [$jobVacancy->id, 'redirectToList' => request('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Company Details --}}
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold"> Job Vacancy Details </h3>
                    <p class="text-gray-500 text-sm pb-5"> Enter the job vacancy details </p>

                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $jobVacancy->title) }}" class=" {{ $errors->has('title') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4 w-full" >
                        <label for="description"> Description </label>
                        <textarea rows="3" type="text" name="description" value="{{ old('description', $jobVacancy->description) }}"
                            class=" {{ $errors->has('description') ? 'border border-red-500' : 'border border-gray-300' }}
                            rounded-md mt-2 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" >
                            {{ old('description', $jobVacancy->description) }}
                        </textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location --}}
                    <div class="mb-2">
                        <label for="location" class="block text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" value="{{ old('location', $jobVacancy->location) }}" class=" {{ $errors->has('location') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Salary --}}
                    <div class="mb-2">
                        <label for="salary" class="block text-gray-700 mb-2">Expected Salary (USD '$')</label>
                        <input type="number" name="salary" value="{{ old('salary', $jobVacancy->salary) }}" class=" {{ $errors->has('salary') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('salary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Type --}}
                    <div class="mb-2">
                        <label for="jobVacancyType" class="block text-gray-700 mb-2">Type</label>
                        <select id="jobVacancyType" name="jobVacancyType" class=" {{ $errors->has('jobVacancyType') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                            @foreach ( $jobVacanciesTypes as $jobVacancyType )
                                <option value="{{ $jobVacancyType }}" {{ old('jobVacancyType', $jobVacancy->type) == $jobVacancyType ? 'selected' : '' }}> {{ $jobVacancyType }} </option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company select Dropdown --}}
                    <div class="mb-2">
                        <label for="companyId" class="block text-gray-700 mb-2">Company</label>
                        <select name="companyId" class=" {{ $errors->has('companyId') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Job Category select Dropdown --}}
                    <div class="mb-2">
                        <label for="jobCategoryId" class="block text-gray-700 mb-2">Job Category</label>
                        <select name="jobCategoryId" class=" {{ $errors->has('jobCategoryId') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                            @foreach ($jobCategories as $category)
                                <option value="{{ $category->id }}" {{ old('jobCategoryId', $jobVacancy->jobCategoryId) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('jobCategoryId')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Add, Cancel Buttons --}}
                <div class="mt-2 flex items-center justify-end">
                    <a href="{{ route('job-vacancies.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Job Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
