<nav class="w-[250px] h-screen bg-white border-r border-gray-200">
    {{-- Application Logo With Name --}}
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center text-lg font-semibold text-gray-900">
            <x-application-logo class="w-auto h-6 fill-current text-gray-800" />
            <span class="ml-3 text-lg font-semibold text-gray-900"> Shaghalni </span>
        </a>
    </div>
    <!-- Navigation Links -->
    <div class="px-6 py-4">
        <ul class="flex flex-col space-y-2">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-nav-link>

            @if ( auth()->user()->isAdmin() )
                <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                    Companies
                </x-nav-link>
            @endif

            @if ( auth()->user()->isCompanyOwner() )
                <x-nav-link :href="route('my-company.show')" :active="request()->routeIs('my-company.*')">
                    My Company
                </x-nav-link>
            @endif

            <x-nav-link :href="route('job-applications.index')" :active="request()->routeIs('job-applications.*')">
                Jobs Applications
            </x-nav-link>

            @if ( auth()->user()->isAdmin() )
                <x-nav-link :href="route('job-categories.index')" :active="request()->routeIs('job-categories.*')">
                    Job Categories
                </x-nav-link>
            @endif

            <x-nav-link :href="route('job-vacancies.index')" :active="request()->routeIs('job-vacancies.*')">
                Job Vacancies
            </x-nav-link>

            @if ( auth()->user()->isAdmin() )
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    Users
                </x-nav-link>
            @endif

            <hr>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <x-nav-link href="#" :active="false" class="text-red-500" onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </x-nav-link>
            </form>

        </ul>
    </div>

</nav>
