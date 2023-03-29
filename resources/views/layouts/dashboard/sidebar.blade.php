<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 overflow-y-auto transition duration-300 transform w-fit bg-slate-600 lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <span class="mx-2 text-xl font-semibold text-white">Direct Sales <br /> Management Dashboard</span>
        </div>
    </div>

    <nav class="mt-10" x-data="{ sales: false, direct: false, school: false, broadcast: false, content: false, event: false, market: false, location: false }">
        <a class="flex items-center px-6 py-2 mt-4 text-gray-100 bg-opacity-25 bg-slate-800"
            href="{{ URL::to('/dashboard') }}">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        @if (auth()->user()->privilege == 'superadmin')
            <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
                x-on:click="content=!content">
                <i class="w-6 h-6 fa-solid fa-list-check"></i>
                <span class="mx-3 text-white select-none">Content Management</span>
                <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                    :class="{ 'rotate-90': content, 'rotate-0': !content }"></i>
            </a>
            <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
                x-show="content" x-transition>
                <a href="{{ route('sapaan.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Sapaan</span></a>
                <a href="{{ route('challenge.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Challenge</span></a>
                <a href="{{ route('slide.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Slide Show</span></a>
                <a href="{{ route('schedule.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Schedule</span></a>
                <a href="{{ route('notification.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Notification</span></a>
                <a href="{{ route('news.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">News</span></a>
                <a href="{{ route('category.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Category</span></a>
            </div>
        @endif

        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="direct=!direct">
            <i class="w-6 h-6 fa-solid fa-user-group"></i>
            <span class="mx-3 text-white select-none">Direct Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': direct, 'rotate-0': !direct }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="direct" x-transition>
            <a href="{{ route('direct_sales.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Resume Direct</span></a>
            <a href="{{ route('direct_user.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Detail Direct</span></a>
            <a href="{{ route('direct_user.absensi') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Absensi</span></a>
            <a href="{{ route('quiz.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Quiz</span></a>
            <a href="{{ route('survey.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Survey</span></a>
            <a href="{{ route('direct_user.clock_in') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Clock In</span></a>
            <a href="{{ route('direct_user.kpi') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">KPI</span></a>
            <a href="{{ route('direct_user.resume_kpi') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Resume KPI</span></a>
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="location=!location">
            <i class="w-6 h-6 fa-solid fa-location-dot"></i>
            <span class="mx-3 text-white select-none">Location</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': location, 'rotate-0': !location }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="location" x-transition>
            <a href="{{ route('location.taps') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">TAPS</span></a>
            <a href="{{ route('location.poi') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">POI</span></a>
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="market=!market">
            <i class="w-6 h-6 fa-solid fa-shop"></i>
            <span class="mx-3 text-white select-none">Market</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': market, 'rotate-0': !market }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="market" x-transition>
            <a href="{{ route('survey.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Survey</span></a>
            <a href="{{ route('survey.lucky_draw') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Lucky Draw</span></a>
        </div>

        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="sales=!sales">
            <i class="w-6 h-6 fa-solid fa-chart-line"></i>
            <span class="mx-3 text-white select-none">Sales</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': sales, 'rotate-0': !sales }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="sales" x-transition>
            <a href="{{ route('sales.migrasi') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Migrasi</span></a>
            <a href="{{ route('sales.orbit') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Orbit by Youth</span></a>
            <a href="{{ route('sales.orbit_digipos') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Orbit by Digipos</span></a>
            <a href="{{ route('sales.digipos') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Digipos</span></a>
            <a href="{{ route('sales.product') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Sales By Product</span></a>
        </div>
        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="school=!school">
            <i class="w-6 h-6 fa-solid fa-school"></i>
            <span class="mx-3 text-white select-none">Sekolah</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': school, 'rotate-0': !school }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="school" x-transition>
            <a href="{{ route('sekolah.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Database</span></a>
            <a href="{{ route('sekolah.resume') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Resume</span></a>
            <a href="{{ route('sekolah.pjp') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">PJP</span></a>
            <a href="{{ route('sekolah.oss_osk') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">OSS OSK</span></a>
            {{-- <a href="{{ route('sales.orbit') }}" class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span class="inline-block px-2 py-3">Orbit</span></a> --}}
        </div>
        <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="broadcast=!broadcast">
            <i class="w-6 h-6 fa-solid fa-tower-broadcast"></i>
            <span class="mx-3 text-white select-none">Campaign</span>
            <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                :class="{ 'rotate-90': broadcast, 'rotate-0': !broadcast }"></i>
        </a>
        <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
            x-show="broadcast" x-transition>
            <a href="{{ route('broadcast.index') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Data Broadcast</span></a>
            <a href="{{ route('broadcast.call') }}"
                class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                    class="inline-block px-2 py-3">Data Call</span></a>
            @if (auth()->user()->privilege != 'cluster')
                <a href="{{ route('campaign.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Wording</span></a>
                <a href="{{ route('whitelist.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Whitelist</span></a>
            @endif
        </div>

        @if (auth()->user()->privilege != 'cluster')
            <a class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
                x-on:click="event=!event">
                <i class="w-6 h-6 fa-solid fa-calendar"></i>
                <span class="mx-3 text-white select-none">Event</span>
                <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right"
                    :class="{ 'rotate-90': event, 'rotate-0': !event }"></i>
            </a>
            <div class="flex flex-col w-3/4 mx-6 mt-2 ml-auto overflow-hidden bg-opacity-25 rounded-md bg-slate-800"
                x-show="event" x-transition>
                <a href="{{ route('event.index') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Peserta</span></a>
                <a href="{{ route('event.resume') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Resume Peserta</span></a>
                <a href="{{ route('event.absen') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Absensi</span></a>
                <a href="{{ route('event.challenge') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Challenge</span></a>
                <a href="{{ route('event.poin_history') }}"
                    class="text-white transition-all border-b hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Poin History</span></a>
            </div>
        @endif
        {{-- <a href="{{ route('outlet.index') }}" class="items-center hidden px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100" x-on:click="outlet=!outlet">
        <i class="w-6 h-6 fa-solid fa-shop"></i>
        <span class="mx-3 text-white select-none">Outlet</span>
        <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': outlet, 'rotate-0': !outlet}"></i>
        </a> --}}


        {{-- <a href="{{ route('direct_user.index') }}" class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100">
        <i class="w-6 h-6 fa-solid fa-users"></i>
        <span class="mx-3 text-white select-none">Database Direct User</span>
        </a> --}}

    </nav>
</div>
