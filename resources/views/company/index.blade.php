<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }} {{ request()->input('archived') == 'true' ? ' (Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        <div class="flex justify-end items-center space-x-4">
            @if ( request()->input('archived') == 'true' )
                {{-- Aactive Company button --}}
                <a href="{{ route('companies.index') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Active Companies
                </a>
            @else
                {{-- Archived Companies button --}}
                <a href="{{ route('companies.index', ['archived' => 'true']) }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Archived Companies
                </a>
            @endif

            {{-- Add Company Button --}}
            <a href="{{ route('companies.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                 Add Company
            </a>
        </div>


        {{-- Company table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-3 ml-4 mr-4 bg-white" >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Company Name </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Address </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Industry </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Website </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Owner </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $companies as $company )
                    <tr class="border-b ">
                        @if ( request()->input('archived') == 'true')
                            <td class="px-6 py-3 text-gray-800"> {{ $company->name }} </td>
                        @endif

                        <td class="px-6 py-3 text-gray-800">
                            <a class="hover:text-blue-700 hover:underline" href="{{ route('companies.show', $company->id) }}">
                                {{ $company->name }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $company->address }} </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $company->industry }} </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $company->website }} </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $company->owner->name }} </td>
                        <td class="flex items-center ">
                            @if ( request()->input('archived') == 'true')
                                <form action="{{ route('companies.restore', $company->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="text-green-500 hover:text-green-700 mr-5"> ♻️ Restore </button>
                                </form>
                            @else
                                <a href="{{ route('companies.edit', $company->id) }} " class="text-blue-500 hover:text-blue-700 mr-5">
                                    ✍🏻 Edit
                                </a>

                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700"> 🗃️ Archive </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-3 text-gray-800 text-center" colspan="6">No companies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5 p-6">
                    {{ $companies->links() }}
        </div>

    </div>

</x-app-layout>
