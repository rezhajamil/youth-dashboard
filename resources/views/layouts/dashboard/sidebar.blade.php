<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="mx-2 text-xl font-semibold text-white">Dashboard <br /> Youth Jawara</span>
        </div>
    </div>

    <nav class="mt-10" x-data="{sales:false,direct:false}">
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="/dashboard">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="direct=!direct">
            <i class="w-6 h-6 fa-solid fa-chart-line"></i>
            <span class="mx-3 text-white">Direct Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': direct, 'rotate-0': !direct}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="direct" x-transition>
            <a href="{{ route('direct_sales.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Resume Direct</span></a>
            <a href="{{ route('direct_user.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Detail Direct</span></a>
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="sales=!sales">
            <i class="w-6 h-6 fa-solid fa-chart-line"></i>
            <span class="mx-3 text-white">Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': sales, 'rotate-0': !sales}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="sales" x-transition>
            <a href="{{ route('sales.migrasi') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Migrasi</span></a>
            <a href="{{ route('sales.orbit') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Orbit</span></a>
        </div>
        {{-- <a href="{{ route('direct_user.index') }}" class="flex items-center px-6 py-2 mt-4 text-gray-500 cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
        <i class="w-6 h-6 fa-solid fa-users"></i>
        <span class="mx-3 text-white">Database Direct User</span>
        </a> --}}

        {{-- <a class="flex items-center px-6 py-2 mt-4 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" href="{{ route('jumat.index') }}">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
        </svg>
        <span class="mx-3">Jadwal Jumat</span>
        </a> --}}
    </nav>
</div>
