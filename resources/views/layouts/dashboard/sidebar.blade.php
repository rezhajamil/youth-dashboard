<div x-cloak :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

<div x-cloak :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 w-fit transform overflow-y-auto bg-slate-600 transition duration-300 lg:static lg:inset-0 lg:translate-x-0">
    <div class="mt-8 flex items-center justify-center">
        <div class="flex items-center">
            <span class="mx-2 text-xl font-semibold text-white">Direct Sales <br /> Management Dashboard</span>
        </div>
    </div>

    <nav class="mt-10" x-data="{ sales: false, kpi: false, direct: false, school: false, broadcast: false, content: false, event: false, market: false, location: false, channel: false, halo: false }">
        <a class="mt-4 flex items-center bg-slate-800 bg-opacity-25 px-6 py-2 text-gray-100"
            href="{{ URL::to('/dashboard') }}">
            <svg class="w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>

            <span class="mx-3">Dashboard</span>
        </a>

        @if (auth()->user()->privilege == 'superadmin')
            <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
                x-on:click="content=!content">
                <i class="fa-solid fa-list-check w-6"></i>
                <span class="mx-3 select-none text-white">Content Management</span>
                <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                    :class="{ 'rotate-90': content, 'rotate-0': !content }"></i>
            </a>
            <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
                x-show="content" x-transition>
                <a href="{{ route('sapaan.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Sapaan</span></a>
                <a href="{{ route('challenge.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Challenge</span></a>
                <a href="{{ route('slide.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Slide Show</span></a>
                <a href="{{ route('schedule.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Schedule</span></a>
                <a href="{{ route('notification.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Notification</span></a>
                <a href="{{ route('news.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">News</span></a>
                <a href="{{ route('category.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Category</span></a>
            </div>
        @endif

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="direct=!direct">
            <i class="fa-solid fa-user-group w-6"></i>
            <span class="mx-3 select-none text-white">Direct Sales</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': direct, 'rotate-0': !direct }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="direct" x-transition>
            <a href="{{ route('direct_sales.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Resume Direct</span></a>
            <a href="{{ route('direct_user.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Detail Direct</span></a>
            <a href="{{ route('direct_user.absensi') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Absensi</span></a>
            <a href="{{ route('quiz.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Quiz</span></a>
            <a href="{{ route('direct_user.clock_in') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Clock In</span></a>
            <a href="{{ route('sekolah.pjp') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">PJP</span></a>
        </div>

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="kpi=!kpi">
            <i class="fa-solid fa-chart-pie w-6"></i>
            <span class="mx-3 select-none text-white">KPI</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': kpi, 'rotate-0': !kpi }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="kpi" x-transition>
            <a href="{{ route('direct_user.kpi') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">KPI Baru</span></a>
            <a href="{{ route('direct_user.resume_kpi') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Resume KPI Baru</span></a>
            <a href="{{ route('direct_user.kpi_old') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">KPI Lama</span></a>
            <a href="{{ route('direct_user.resume_kpi_old') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Resume KPI Lama</span></a>
            <a href="{{ route('direct_user.kpi_yba') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">KPI YBA</span></a>
        </div>

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="location=!location">
            <i class="fa-solid fa-location-dot w-6"></i>
            <span class="mx-3 select-none text-white">Location</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': location, 'rotate-0': !location }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="location" x-transition>
            <a href="{{ route('location.taps') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">TAPS</span></a>
            <a href="{{ route('location.poi') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">POI</span></a>
            <a href="{{ route('location.site') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">SITE</span></a>
        </div>

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="market=!market">
            <i class="fa-solid fa-shop w-6"></i>
            <span class="mx-3 select-none text-white">Market</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': market, 'rotate-0': !market }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="market" x-transition>
            <a href="{{ route('survey.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Survey</span></a>
            <a href="{{ route('survey.fb_share') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">FB Share</span></a>
            <a href="{{ route('survey.lucky_draw') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Lucky Draw</span></a>
        </div>

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="sales=!sales">
            <i class="fa-solid fa-chart-line w-6"></i>
            <span class="mx-3 select-none text-white">Sales</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': sales, 'rotate-0': !sales }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="sales" x-transition>
            <a href="{{ route('sales.migrasi') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Migrasi</span></a>
            <a href="{{ route('sales.orbit') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Orbit by Youth</span></a>
            <a href="{{ route('sales.orbit_digipos') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Orbit by Digipos</span></a>
            <a href="{{ route('sales.digipos') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Digipos</span></a>
            <a href="{{ route('sales.product') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Sales By Product</span></a>
            <a href="{{ route('sales.location') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Sales By Location</span></a>
            <a href="{{ route('event.create_peserta_sekolah') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Upload Bulk BYU</span></a>
        </div>
        {{-- <a class="flex items-center px-6 py-2 mt-4 text-white transition-all bg-opacity-25 cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            href="{{ route('byu.index') }}">
            <i class="fa-solid fa-sim-card"></i>
            <span class="mx-6">By.U</span>
        </a> --}}
        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="school=!school">
            <i class="fa-solid fa-school w-6"></i>
            <span class="mx-3 select-none text-white">Sekolah</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': school, 'rotate-0': !school }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="school" x-transition>
            <a href="{{ route('sekolah.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Database</span></a>
            <a href="{{ route('sekolah.resume') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Resume</span></a>
            <a href="{{ route('sekolah.favorit') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Sekolah P1</span></a>
            {{-- <a href="{{ route('sales.orbit') }}" class="text-white transition-all border-b select-none hover:bg-white hover:text-slate-800 border-b-slate-400"><span class="inline-block px-2 py-3">Orbit</span></a> --}}
        </div>
        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="channel=!channel">
            <i class="fa-solid fa-tv w-6"></i>
            <span class="mx-3 select-none text-white">Channel</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': channel, 'rotate-0': !channel }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="channel" x-transition>
            <a href="{{ route('sekolah.oss_osk') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">OSS OSK</span></a>
            <a href="{{ URL::to('/answer_list/survey?session=27') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Travel</span></a>
        </div>
        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="broadcast=!broadcast">
            <i class="fa-solid fa-tower-broadcast w-6"></i>
            <span class="mx-3 select-none text-white">Campaign</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': broadcast, 'rotate-0': !broadcast }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="broadcast" x-transition>
            <a href="{{ route('broadcast.index') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Data Broadcast</span></a>
            <a href="{{ route('broadcast.call') }}"
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Data Call</span></a>
            @if (auth()->user()->privilege != 'cluster')
                <a href="{{ route('campaign.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Wording</span></a>
                <a href="{{ route('whitelist.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Whitelist</span></a>
            @endif
        </div>

        @if (auth()->user()->privilege != 'cluster')
            <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
                x-on:click="event=!event">
                <i class="fa-solid fa-calendar w-6"></i>
                <span class="mx-3 select-none text-white">Event</span>
                <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                    :class="{ 'rotate-90': event, 'rotate-0': !event }"></i>
            </a>
            <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
                x-show="event" x-transition>
                <a href="{{ route('event.index') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Peserta</span></a>
                <a href="{{ route('event.resume') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Resume Peserta</span></a>
                {{-- <a href="{{ route('event.create_peserta_sekolah') }}"
                    class="text-white transition-all border-b select-none hover:bg-white hover:text-slate-800 border-b-slate-400"><span
                        class="inline-block px-2 py-3">Form Upload Peserta</span></a> --}}
                <a href="{{ route('event.absen') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Absensi</span></a>
                <a href="{{ route('event.challenge') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Challenge</span></a>
                <a href="{{ route('event.poin_history') }}"
                    class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                        class="inline-block px-2 py-3">Poin History</span></a>
            </div>
        @endif

        <a class="mt-4 flex cursor-pointer items-center px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            x-on:click="halo=!halo">
            <i class="fa-solid fa-hand w-6"></i>
            <span class="mx-3 select-none text-white">Halo</span>
            <i class="fa-solid fa-angle-right ml-auto inline-block transform text-white transition-transform"
                :class="{ 'rotate-90': halo, 'rotate-0': !halo }"></i>
        </a>
        <div class="mx-6 ml-auto mt-2 flex w-3/4 flex-col overflow-hidden rounded-md bg-slate-800 bg-opacity-25"
            x-show="halo" x-transition>
            <a href=""
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Store</span></a>
            <a href=""
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Stok</span></a>
            <a href=""
                class="select-none border-b border-b-slate-400 text-white transition-all hover:bg-white hover:text-slate-800"><span
                    class="inline-block px-2 py-3">Survey</span></a>
        </div>


        <a class="mt-4 flex cursor-pointer items-center bg-opacity-25 px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            href="{{ route('download.index') }}">
            <i class="fa-solid fa-download"></i>
            <span class="mx-6">Download</span>
        </a>

        <a class="mt-4 flex cursor-pointer items-center bg-opacity-25 px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            href="{{ route('dokumen.index') }}">
            <i class="fa-solid fa-file"></i>
            <span class="mx-6">Dokumen</span>
        </a>

        <a class="mt-4 flex cursor-pointer items-center bg-opacity-25 px-6 py-2 text-white transition-all hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100"
            href="{{ route('sertifikat.index') }}">
            <i class="fa-solid fa-certificate"></i>
            <span class="mx-6">Sertifikat</span>
        </a>
        {{-- <a href="{{ route('outlet.index') }}" class="items-center hidden px-6 py-2 mt-4 text-gray-500 transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100" x-on:click="outlet=!outlet">
        <i class="w-6 fa-solid fa-shop"></i>
        <span class="mx-3 text-white select-none">Outlet</span>
        <i class="inline-block ml-auto text-white transition-transform transform fa-solid fa-angle-right" :class="{'rotate-90': outlet, 'rotate-0': !outlet}"></i>
        </a> --}}


        {{-- <a href="{{ route('direct_user.index') }}" class="flex items-center px-6 py-2 mt-4 text-white transition-all cursor-pointer hover:bg-slate-800 hover:bg-opacity-25 hover:text-gray-100">
        <i class="w-6 fa-solid fa-users"></i>
        <span class="mx-3 text-white select-none">Database Direct User</span>
        </a> --}}

    </nav>
</div>
