<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">
        {{-- Overviewe Cards --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- Active Users --}}
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg gap-4 justify-items-center">
                <h3 class="text-lg font-medium text-gary-900"> Active Users </h3>
                <p class="text-2xl font-bold text-indigo-600 p"> {{ $analytics['totalActiveUsersAtLastOneMonth'] }} </p>
                <p class="text-sm font-sans text-gray-500"> Last 30 days </p>

            </div>

            {{-- Total Jobs --}}
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg justify-items-center">
                <h3 class="text-lg font-medium text-gary-900"> Total Job Vacancies </h3>
                <p class="text-2xl font-bold text-indigo-600"> {{ $analytics['totalActiveJobVacancies'] }} </p>
                <p class="text-sm font-sans text-gray-500"> All time </p>
            </div>

            {{-- Total Jobs --}}
            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg justify-items-center">
                <h3 class="text-lg font-medium text-gary-900"> Total Applications </h3>
                <p class="text-2xl font-bold text-indigo-600"> {{ $analytics['totalActiveApplications'] }} </p>
                <p class="text-sm font-sans text-gray-500"> All time </p>
            </div>
        </div>

        {{-- Most Applied Jobs --}}
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gary-900"> Most Applied Job Vacancies (Top 5) </h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 text-gray-500 uppercase"> Job Title </th>
                            @if ( auth()->user()->isAdmin() )
                                <th class="py-2 text-gray-500 uppercase"> Company </th>
                            @endif
                            <th class="py-2 text-gray-500 uppercase"> Total Applications </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ( $analytics['mostAppliedJobs'] as $mostAppliedJob )
                            <tr>
                                <td class="py-4"> {{ $mostAppliedJob->title  }} </td>
                                @if ( auth()->user()->isAdmin() )
                                    <td class="py-4"> {{ $mostAppliedJob->company->name }} </td>
                                @endif
                                <td class="py-4"> {{ $mostAppliedJob->totalCount }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Conversion Rate --}}
        <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
            <h3 class="text-lg font-medium text-gary-900"> Conversion Rate (Top 5) </h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2 text-gray-500 uppercase"> Job Title </th>
                            <th class="py-2 text-gray-500 uppercase"> Views </th>
                            <th class="py-2 text-gray-500 uppercase">  Applications </th>
                            <th class="py-2 text-gray-500 uppercase"> Conversion Rate </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ( $analytics['conversionRates'] as $conversionRate )
                            <tr>
                                <td class="py-4"> {{ $conversionRate->title }} </td>
                                <td class="py-4"> {{ $conversionRate->viewCount }} </td>
                                <td class="py-4"> {{ $conversionRate->totalCount }} </td>
                                <td class="py-4"> {{ $conversionRate->conversionRate }}% </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
