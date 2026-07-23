<x-app-layout>
    {{-- Helper Varibles to reduce replication --}}
    @php
        $archivedParameter = request()->input('archived') == 'true';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }} {{ $archivedParameter == 'true' ? ' (Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        <div class="flex justify-end items-center space-x-4">
            @if ( $archivedParameter == 'true' )
                {{-- Active Vacancies button --}}
                <a href="{{ route('job-vacancies.index') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Active Vacancies
                </a>
            @else
                {{-- Archived Vacancies button --}}
                <a href="{{ route('job-vacancies.index', ['archived' => 'true']) }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Archived Vacancies
                </a>
            @endif

            {{-- Add Vacancy Button --}}
            <a href="{{ route('job-vacancies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                 Add Job Vacancy
            </a>
        </div>


        {{-- Vacancy table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-3 ml-4 mr-4 bg-white" >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Title </th>
                    @if ( auth()->user()->isAdmin() )
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Company Name </th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Location </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Type </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Salary </th>
                    <th class="px-16 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $vacancies as $vacancy )
                    <tr class="border-b ">
                        @if ( $archivedParameter == 'true')
                            <td class="px-6 py-3 text-gray-800 text-left"> {{ $vacancy->title }} </td>
                        @else
                            <td class="px-6 py-3 text-gray-800">
                                <a class="hover:text-blue-700 hover:underline" href="{{ route('job-vacancies.show', $vacancy->id) }}">
                                    {{ $vacancy->title }}
                                </a>
                            </td>
                        @endif
                        @if ( auth()->user()->isAdmin() )
                            <td class="px-6 py-3 text-gray-800"> {{ $vacancy->company->name }} </td>
                        @endif
                        <td class="px-6 py-3 text-gray-800"> {{ $vacancy->location }} </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $vacancy->type }} </td>
                        <td class="px-6 py-3 text-gray-800">
                            ${{ number_format($vacancy->salary, 2) }}
                        </td>
                        <td class="flex items-center px-6 py-3">
                            @if ( $archivedParameter == 'true')
                                <form action="{{ route('job-vacancies.restore', $vacancy->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="text-green-500 hover:text-green-700 mr-5 px-5"> ♻️ Restore </button>
                                </form>
                            @else
                                <a href="{{ route('job-vacancies.edit', $vacancy->id) }} " class="text-blue-500 hover:text-blue-700 mr-5">
                                    ✍🏻 Edit
                                </a>

                                <form action="{{ route('job-vacancies.destroy', $vacancy->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700"> 🗃️ Archive </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-3 text-gray-800 text-center" colspan="7">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5 p-6">
            {{ $vacancies->links() }}
        </div>
    </div>

</x-app-layout>
