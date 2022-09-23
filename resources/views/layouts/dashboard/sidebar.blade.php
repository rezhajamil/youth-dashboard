<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="mx-2 text-xl font-semibold text-white">Dashboard <br /> Youth Jawara</span>
        </div>
    </div>

    <nav class="mt-10" x-data="{sales:false,direct:false,school:false,broadcast:false,content:false,event:false}">
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-gray-700 bg-opacity-25" href="{{ URL::to('/dashboard') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        @if (auth()->user()->privilege=="superadmin")
        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="content=!content">
            <i class="w-6 h-6 fa-solid fa-list-check"></i>
            <span class="mx-3 text-white">Content Management</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': content, 'rotate-0': !content}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="content" x-transition>
            <a href="{{ route('sapaan.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Sapaan</span></a>
            <a href="{{ route('challenge.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Challenge</span></a>
            <a href="{{ route('slide.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Slide Show</span></a>
            <a href="{{ route('schedule.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Schedule</span></a>
            <a href="{{ route('notification.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Notification</span></a>
            <a href="{{ route('news.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">News</span></a>
            <a href="{{ route('category.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Category</span></a>
        </div>
        @endif

        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="direct=!direct">
            <i class="w-6 h-6 fa-solid fa-user-group"></i>
            <span class="mx-3 text-white">Direct Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': direct, 'rotate-0': !direct}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="direct" x-transition>
            <a href="{{ route('direct_sales.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Resume Direct</span></a>
            <a href="{{ route('direct_user.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Detail Direct</span></a>
            <a href="{{ route('direct_user.absensi') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Absensi</span></a>
            @if (Auth::user()->privilege=='superadmin')
            <a href="{{ route('quiz.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Quiz</span></a>
            <a href="{{ route('survey.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Survey</span></a>
            @endif
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="sales=!sales">
            <i class="w-6 h-6 fa-solid fa-chart-line"></i>
            <span class="mx-3 text-white">Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': sales, 'rotate-0': !sales}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="sales" x-transition>
            <a href="{{ route('sales.migrasi') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Migrasi</span></a>
            <a href="{{ route('sales.orbit') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Orbit</span></a>
            <a href="{{ route('sales.digipos') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Digipos</span></a>
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="school=!school">
            <i class="w-6 h-6 fa-solid fa-school"></i>
            <span class="mx-3 text-white">Sekolah</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': school, 'rotate-0': !school}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="school" x-transition>
            <a href="{{ route('sekolah.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Database</span></a>
            <a href="{{ route('sekolah.resume') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Resume</span></a>
            <a href="{{ route('sekolah.pjp') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">PJP</span></a>
            <a href="{{ route('sekolah.oss_osk') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">OSS OSK</span></a>
            {{-- <a href="{{ route('sales.orbit') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Orbit</span></a> --}}
        </div>
        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="broadcast=!broadcast">
            <i class="w-6 h-6 fa-solid fa-tower-broadcast"></i>
            <span class="mx-3 text-white">Broadcast</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': broadcast, 'rotate-0': !broadcast}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="broadcast" x-transition>
            <a href="{{ route('broadcast.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Data Broadcast</span></a>
            <a href="{{ route('campaign.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Campaign</span></a>
            <a href="{{ route('whitelist.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Whitelist</span></a>
        </div>
        <a class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="event=!event">
            <i class="w-6 h-6 fa-solid fa-calendar"></i>
            <span class="mx-3 text-white">Event</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': event, 'rotate-0': !event}"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-gray-700 rounded-md" x-show="event" x-transition>
            <a href="{{ route('event.index') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Peserta</span></a>
            <a href="{{ route('event.resume') }}" class="text-white transition-all border-b hover:bg-white hover:text-gray-700 border-b-gray-900"><span class="inline-block px-2 py-3">Resume Peserta</span></a>
        </div>
        {{-- <a href="{{ route('outlet.index') }}" class="items-center hidden px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100" x-on:click="outlet=!outlet">
        <i class="w-6 h-6 fa-solid fa-shop"></i>
        <span class="mx-3 text-white">Outlet</span>
        <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': outlet, 'rotate-0': !outlet}"></i>
        </a> --}}


        {{-- <a href="{{ route('direct_user.index') }}" class="flex items-center px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100">
        <i class="w-6 h-6 fa-solid fa-users"></i>
        <span class="mx-3 text-white">Database Direct User</span>
        </a> --}}

    </nav>
</div>
