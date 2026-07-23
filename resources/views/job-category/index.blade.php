<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }} {{ request()->input('archived') == 'true' ? ' (Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        <x-toast-notification/>

        <div class="flex justify-end items-center space-x-4">
            @if ( request()->input('archived') == 'true' )
                {{-- Active Categories button --}}
                <a href="{{ route('job-categories.index') }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Active Categories
                </a>
            @else
                {{-- Archived Categories button --}}
                <a href="{{ route('job-categories.index', ['archived' => 'true']) }}" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                    Archived Categories
                </a>
            @endif

            {{-- Add Job Category Button --}}
            <a href="{{ route('job-categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                 Add Job Category
            </a>
        </div>

        {{-- Job Category table --}}
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-3 ml-4 mr-4 bg-white" >
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Category Name </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Action </th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $categories as $category )
                    <tr class="border-b ">
                        <td class="px-6 py-3 text-gray-800"> {{ $category->name }} </td>
                        <td class="flex items-center ">
                            @if ( request()->input('archived') == 'true')
                                <form action="{{ route('job-categories.restore', $category->id) }}" method="POST">
                                    @csrf
                                    @method('put')

                                    <button class="text-green-500 hover:text-green-700 mr-5"> ♻️ Restore </button>
                                </form>
                            @else
                                <a href="{{ route('job-categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700 mr-5">
                                    ✍🏻 Edit
                                </a>

                                <form action="{{ route('job-categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button class="text-red-500 hover:text-red-700"> 🗃️ Archive </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-3 text-gray-800" colspan="2">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-5 p-6">
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>
