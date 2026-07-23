<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auot p-6">
        {{-- // Let the sectioon in the center design with a card and a shadow --}}
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-categories.update', $jobCategory->id) }}" method="POST">
                @csrf
                @method('put')

                <div>
                    <label for="name" class="block text-gray-700 font-bold mb-2">Category Name:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $jobCategory->name) }}" class=" {{ $errors->any() ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >

                </div>

                {{-- all error messages --}}
                <x-error-message />

                <div class="mt-4 flex items-center justify-end">
                    <a href="{{ route('job-categories.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
