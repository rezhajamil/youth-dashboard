<!-- component -->
<div class="flex flex-col h-full">
    <header class="flex items-center justify-between flex-none px-6 py-4 border-b border-gray-200">
        <h1 class="text-base font-semibold leading-6 text-gray-900">
            <time datetime="{{ date('Y-m-d', strtotime($startDate)) }}">{{ date('d M Y', strtotime($startDate)) }}
                {{ $endDate ? ' - ' . date('d M Y', strtotime($endDate)) : '' }}</time>
        </h1>
    </header>
    <div class="flex flex-col flex-auto shadow ring-1 ring-black ring-opacity-5">
        <div
            class="grid flex-none grid-cols-7 gap-px text-xs font-semibold leading-6 text-center text-gray-700 bg-gray-200 border-b border-gray-300">
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
        <div class="flex flex-auto text-xs leading-6 text-gray-700 bg-gray-200">
            @php
                $startDate = \Carbon\Carbon::parse($startDate);
                $endDate = \Carbon\Carbon::parse($endDate);
                $currentDate = \Carbon\Carbon::parse($startDate)->startOfWeek();
                $endMonth = \Carbon\Carbon::parse($endDate)->endOfMonth();
                $lastDate = \Carbon\Carbon::parse($endMonth)->endOfWeek();
                $numberOfWeeks = ceil($currentDate->diffInDays($lastDate) / 7);
            @endphp
            <div class="grid-rows-{{ $numberOfWeeks }} grid w-full grid-cols-7 gap-px">
                @while ($currentDate <= $lastDate)
                    @php
                        // $isCurrentMonth = $currentDate->month == \Carbon\Carbon::parse($startDate)->month;
                        $isCurrentMonth = $currentDate >= $startDate && $currentDate <= $endDate;
                        $isToday = $currentDate->isToday();
                    @endphp

                    <div class="{{ $isCurrentMonth ? 'bg-white' : 'bg-gray-200 text-gray-500' }} relative px-3 py-2">
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
                            @php
                                $regionalCounts = $keberangkatan
                                    ->groupBy('travel.territory.regional')
                                    ->map(function ($group) use ($currentDate) {
                                        return $group->where('tgl', $currentDate->format('Y-m-d'))->sum('jlh');
                                    })
                                    ->filter();

                                $clusterCounts = $keberangkatan
                                    ->groupBy('travel.territory.cluster')
                                    ->map(function ($group) use ($currentDate) {
                                        return $group->where('tgl', $currentDate->format('Y-m-d'))->sum('jlh');
                                    })
                                    ->filter();
                            @endphp
                            @if (Auth::user()->privilege == 'superadmin')
                                <ol class="mt-2">
                                    @foreach ($regionalCounts as $idx => $item)
                                        <li>
                                            <a href="#" class="flex group">
                                                <p
                                                    class="flex-auto font-medium text-gray-900 truncate group-hover:text-indigo-600">
                                                    {{ ucwords(strtolower($idx)) ?? '' }}
                                                </p>
                                                <time datetime="{{ $item->tgl ?? '2024-08-10T10:00' }}"
                                                    class="flex-none hidden ml-3 text-gray-500 group-hover:text-indigo-600 md:block">
                                                    {{ $item ?? '0' }}
                                                </time>
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                                <hr class="h-1">
                            @endif
                            <ol class="mt-2">
                                @foreach ($clusterCounts as $idx => $item)
                                    <li>
                                        <a href="#" class="flex group">
                                            <p
                                                class="flex-auto font-medium text-gray-900 truncate group-hover:text-indigo-600">
                                                {{ ucwords(strtolower($idx)) ?? '' }}
                                            </p>
                                            <time datetime="{{ $item->tgl ?? '2024-08-10T10:00' }}"
                                                class="flex-none hidden ml-3 text-gray-500 group-hover:text-indigo-600 md:block">
                                                {{ $item ?? '0' }}
                                            </time>
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                            <hr class="h-1">
                            <ol class="mt-2">
                                @foreach ($data->where('tgl', $currentDate->format('Y-m-d')) as $item)
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
                                @endforeach
                            </ol>
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
