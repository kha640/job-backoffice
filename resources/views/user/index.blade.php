<x-app-layout>
    {{-- Helper Varibles to reduce replication --}}
    @php
        $archivedParameter = request()->input('archived') == 'true';
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('users') }} {{ $archivedParameter == 'true' ? ' (Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        <div class="flex justify-end items-center space-x-4">
            @if ( $archivedParameter == 'true' )
                {{-- Active users button --}}
                <a href="{{ route('users.index') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Active users
                </a>
            @else
                {{-- Archived users button --}}
                <a href="{{ route('users.index', ['archived' => 'true']) }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Archived users
                </a>
            @endif
        </div>

        {{-- Job Applications table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-3 ml-4 mr-4 bg-white" >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Name </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Email </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Role </th>
                    <th class="px-16 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $users as $user )
                    <tr class="border-b ">
                        <td class="px-6 py-3 text-gray-800 text-left">
                            <span href="{{ route('users.show', $user->id) }}">
                                {{ $user->name }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-800"> {{ $user->email }} </td>
                        <td class="px-6 py-3 text-gray-800 @if( $user->isAdmin()) text-red-600 @elseif( $user->isCompanyOwner()) text-purple-500 @elseif( $user->isJobSeeker()) text-gray-600 @endif"> {{ $user->role }} </td>
                        <td class="flex items-center px-6 py-3">
                            @if ( $archivedParameter == 'true')
                                <form action="{{ route('users.restore', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="text-green-500 hover:text-green-700 mr-5 px-5"> ♻️ Restore </button>
                                </form>
                            @else
                                @if ( $user->role != 'admin' )
                                    <a href="{{ route('users.edit', $user->id) }} " class="text-blue-500 hover:text-blue-700 mr-5">
                                        ✍🏻 Edit
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-500 hover:text-red-700"> 🗃️ Archive </button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-3 text-gray-800 text-center" colspan="6">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5 p-6">
            {{ $users->links() }}
        </div>
    </div>

</x-app-layout>
