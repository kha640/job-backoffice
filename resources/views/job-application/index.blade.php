<x-app-layout>
    {{-- Helper Varibles to reduce replication --}}
    @php
        $archivedParameter = request()->input('archived') == 'true';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{ $archivedParameter == 'true' ? ' (Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        <div class="flex justify-end items-center space-x-4">
            @if ( $archivedParameter == 'true' )
                {{-- Active Vacancies button --}}
                <a href="{{ route('job-applications.index') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Active Applications
                </a>
            @else
                {{-- Archived Vacancies button --}}
                <a href="{{ route('job-applications.index', ['archived' => 'true']) }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Archived Applications
                </a>
            @endif
        </div>

        {{-- Job Applications table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-3 ml-4 mr-4 bg-white" >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Applicant Name </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Position (Job Vacancy) </th>
                    @if ( auth()->user()->isAdmin() )
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Company </th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Status </th>
                    <th class="px-16 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $jobApplications as $jobApplication )
                    <tr class="border-b ">
                        <td class="px-6 py-3 text-gray-800 text-left">
                            <a href="{{ route('job-applications.show', $jobApplication->id) }}" class="hover:text-blue-700 hover:underline">
                                {{ $jobApplication->user->name }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-gray-800">
                            <a class="hover:text-blue-700 hover:underline" href="{{ route('job-vacancies.show', $jobApplication->jobVacancy?->id ?? 'N/A') }}">
                                {{ $jobApplication->jobVacancy?->title ?? 'N/A' }}
                            </a>
                        </td>
                        @if ( auth()->user()->isAdmin() )
                            <td class="px-6 py-3 text-gray-800"> {{ $jobApplication->jobVacancy->company->name}} </td>
                        @endif
                        <td class="px-6 py-3 text-gray-800 @if( $jobApplication->status == 'accepted') text-green-500 @elseif( $jobApplication->status == 'rejected') text-red-500 @elseif( $jobApplication->status == 'pending') text-purple-500 @endif"> {{ $jobApplication->status }} </td>
                        <td class="flex items-center px-6 py-3">
                            @if ( $archivedParameter == 'true')
                                <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="text-green-500 hover:text-green-700 mr-5 px-5"> ♻️ Restore </button>
                                </form>
                            @else
                                <a href="{{ route('job-applications.edit', $jobApplication->id) }} " class="text-blue-500 hover:text-blue-700 mr-5">
                                    ✍🏻 Edit
                                </a>

                                <form action="{{ route('job-applications.destroy', $jobApplication->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700"> 🗃️ Archive </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-3 text-gray-800 text-center" colspan="6">No job applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5 p-6">
            {{ $jobApplications->links() }}
        </div>
    </div>

</x-app-layout>
