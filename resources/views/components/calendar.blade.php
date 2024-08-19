<!-- component -->
<div class="lg:flex lg:h-full lg:flex-col">
    <header class="flex items-center justify-between px-6 py-4 border-b border-gray-200 lg:flex-none">
        <h1 class="text-base font-semibold leading-6 text-gray-900">
            <time datetime="{{ date('Y-m-d', strtotime($startDate)) }}">{{ date('d M Y', strtotime($startDate)) }}
                {{ $endDate ? ' - ' . date('d M Y', strtotime($endDate)) : '' }}</time>
        </h1>
    </header>
    <div class="shadow ring-1 ring-black ring-opacity-5 lg:flex lg:flex-auto lg:flex-col">
        <div
            class="grid grid-cols-7 gap-px text-xs font-semibold leading-6 text-center text-gray-700 bg-gray-200 border-b border-gray-300 lg:flex-none">
            <div class="flex justify-center py-2 bg-white">
                <span>M</span>
                <span class="sr-only sm:not-sr-only">on</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>T</span>
                <span class="sr-only sm:not-sr-only">ue</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>W</span>
                <span class="sr-only sm:not-sr-only">ed</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>T</span>
                <span class="sr-only sm:not-sr-only">hu</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>F</span>
                <span class="sr-only sm:not-sr-only">ri</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>S</span>
                <span class="sr-only sm:not-sr-only">at</span>
            </div>
            <div class="flex justify-center py-2 bg-white">
                <span>S</span>
                <span class="sr-only sm:not-sr-only">un</span>
            </div>
        </div>
        <div class="flex text-xs leading-6 text-gray-700 bg-gray-200 lg:flex-auto">
            @php
                $currentDate = \Carbon\Carbon::parse($startDate)->startOfWeek();
                $endMonth = \Carbon\Carbon::parse($endDate)->endOfMonth();
                $lastDate = \Carbon\Carbon::parse($endMonth)->endOfWeek();
                $numberOfWeeks = ceil($currentDate->diffInDays($lastDate) / 7);
            @endphp
            <div class="lg:grid-rows-{{ $numberOfWeeks }} hidden w-full lg:grid lg:grid-cols-7 lg:gap-px">

                @while ($currentDate <= $lastDate)
                    @php
                        // $isCurrentMonth = $currentDate->month == \Carbon\Carbon::parse($startDate)->month;
                        $isCurrentMonth = $currentDate >= $startDate && $currentDate <= $endDate;
                        $isToday = $currentDate->isToday();
                    @endphp

                    <div class="{{ $isCurrentMonth ? 'bg-white' : 'bg-gray-100 text-gray-500' }} relative px-3 py-2">
                        @if ($isToday)
                            <time datetime="{{ $currentDate->format('Y-m-d') }}"
                                class="flex items-center justify-center w-6 h-6 font-bold text-white bg-indigo-600 rounded-full">
                                {{ $currentDate->format('j') }}
                            </time>
                        @else
                            <time datetime="{{ $currentDate->format('Y-m-d') }}" class="font-bold">
                                {{ $currentDate->format('j') }}
                            </time>
                        @endif

                        @if ($data->where('tgl', $currentDate->format('Y-m-d'))->isNotEmpty())
                            @foreach ($data->where('tgl', $currentDate->format('Y-m-d')) as $item)
                                <ol class="mt-2">
                                    <li>
                                        <a href="#" class="flex group">
                                            <p
                                                class="flex-auto font-medium text-gray-900 truncate group-hover:text-indigo-600">
                                                {{ $item->negara ?? '' }}
                                            </p>
                                            <time datetime="{{ $item->tgl ?? '2024-08-10T10:00' }}"
                                                class="flex-none hidden ml-3 text-gray-500 group-hover:text-indigo-600 md:block">
                                                {{ $item->jlh ?? '0' }}
                                            </time>
                                        </a>
                                    </li>
                                </ol>
                            @endforeach
                        @endif
                    </div>

                    @php
                        $currentDate->addDay();
                    @endphp
                @endwhile
            </div>
        </div>
    </div>
</div>
