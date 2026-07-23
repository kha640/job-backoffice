@php
    if ( auth()->user()->isAdmin() ) {
        $formAction = route('companies.update', [ 'company' => $company->id, 'redirectToList' => request('redirectToList') ]) ;
    } else if ( auth()->user()->isCompanyOwner() ) {
        $formAction = route('my-company.update');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Edit Company: ' . $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-4 bg-white rounded-lg shadow-md">
            <form action="{{ $formAction }}" method="POST">
                @csrf
                @method('put')

                {{-- Company Details --}}
                <div class="mb-4 p-4 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold"> Company Details </h3>
                    <p class="text-gray-500 text-sm pb-5"> Enter the company details </p>

                    {{-- Company Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2">Company Name</label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}" class=" {{ $errors->has('name') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company Address --}}
                    <div class="mb-2">
                        <label for="address" class="block text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" value="{{ old('address', $company->address) }}" class=" {{ $errors->has('address') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company Industry --}}
                    <div class="mb-2">
                        <label for="industry" class="block text-gray-700 mb-2">Industry</label>
                        <select name="industry" class=" {{ $errors->has('industry') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                    {{ $industry }}
                                </option>
                            @endforeach
                        </select>
                        @error('industry')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Company Website --}}
                    <div class="mb-2">
                        <label for="website" class="block text-gray-700 mb-2">Website (Optional)</label>
                        <input type="text" name="website" value="{{ old('website', $company->website) }}" class=" {{ $errors->has('website') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full" >
                        @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Owner Details --}}
                <div class="mb-4 p-4 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-bold"> Owner Details </h3>
                    <p class="text-gray-500 text-sm pb-5"> Enter the owner details </p>

                    {{-- Owner Name --}}
                    <div class="mb-4">
                        <label for="owner_name" class="block text-gray-700 mb-2">Owner Name</label>
                        <input id="owner_name" type="text" name="owner_name" value="{{ old('owner_name', $company->owner->name) }}" class=" {{ $errors->has('owner_name') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full " >
                        @error('owner_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Owner Email ( Read Only - Cannot be changed ) --}}
                    <div class="mb-4">
                        <label for="owner_email" class="block text-gray-700 mb-2">
                            Owner Email (Cannot be changed)
                        </label>
                        <input disabled type="email" name="owner_email" value="{{ old('owner_email', $company->owner->email) }}" class=" {{ $errors->has('owner_email') ? 'border border-red-500' : 'border border-gray-300' }} rounded-md p-2 w-full bg-gray-200" >
                        @error('owner_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Owner Password ( Can Update The Password ) --}}
                    <div class="mb-4">
                        <label for="owner_password" class="block text-gray-700 mb-2">
                            Change Owner Password (Leave blank to keep current)
                        </label>
                        <div class="relative" x-data="{ showPassword: false }">

                            <x-text-input value="{{ old('owner_password') }}" x-bind:type="showPassword ? 'text' : 'password'" id="owner_password" class="block mt-1 w-full" name="owner_password" autocomplete="current-password" />

                            @error('owner_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-2 flex items-center text-gray-500">
                                {{-- Eye Closed Icon --}}
                                <svg x-show="!showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                {{-- Eye Open Icon --}}
                                <svg x-show="showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Add, Cancel Buttons --}}
                <div class="mt-4 flex items-center justify-end">
                    @if ( auth()->user()->isAdmin() )
                        <a href="{{ route('companies.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                            Cancel
                        </a>
                    @endif

                    @if ( auth()->user()->isCompanyOwner() )
                        <a href="{{ route('my-company.show') }}" class="text-gray-500 hover:text-gray-700 mr-4">
                            Cancel
                        </a>
                    @endif


                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Company
                    </button>
                </div>


            </form>
        </div>
    </div>

</x-app-layout>
