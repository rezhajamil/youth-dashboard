<header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-y_premier">
    <div class="flex items-center">
        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>

    <img src="{{ asset('images/logo-new.png') }}" alt="logo" class="sm:w-16 w-8 ml-2" style="width: 4rem">
    <img src="{{ asset('images/logo-new-text.png') }}" alt="logo" class="sm:w-40 w-28 ml-2 mr-auto">

    <div class="flex items-center gap-x-4">
        <div class="flex flex-col">
            <span class="font-bold text-y_premier">{{ auth()->user()->name }}</span>
            <span
                class="text-xs text-gray-600">{{ auth()->user()->privilege == 'cluster' ? auth()->user()->cluster : auth()->user()->branch }}</span>
        </div>
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen"
                class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                <img class="object-cover w-full h-full" src="{{ asset('images/profile.png') }}" alt="Your avatar">
            </button>

            <div x-cloak x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full">
            </div>

            <div x-cloak x-show="dropdownOpen"
                class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
                {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-y_premier hover:text-white">Profile</a> --}}
                <a href="{{ URL::to('/logout') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-y_premier hover:text-white">Logout</a>
            </div>
        </div>
    </div>
</header>
