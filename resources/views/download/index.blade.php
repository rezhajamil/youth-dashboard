@extends('layouts.dashboard.app')
@section('body')
    <div class="mx-4 my-4 w-full">
        <div class="flex flex-col">
            <div class="mt-4">
                <h4 class="align-baseline text-xl font-bold text-gray-600">Download Data CSV</h4>
                {{-- <span class="text-sm">Update : {{ $update[0]->last_update }}</span> --}}
                <div class="mt-4 flex justify-between">
                    <form class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2" action="{{ route('download.csv') }}"
                        method="get">
                        <input type="date" name="date" id="date" class="rounded-lg px-4"
                            value="{{ request()->get('date') }}" required>
                        <select name="jenis" id="jenis" class="rounded-lg px-8" required>
                            <option value="" selected disabled>Pilih Jenis</option>
                            @foreach ($list_jenis as $data)
                                <option value="{{ $data }}"
                                    {{ $data == request()->get('jenis') ? 'selected' : '' }}>
                                    {{ ucWords(strtolower($data)) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="flex gap-x-3">
                            <button
                                class="rounded-lg bg-y_premier px-4 py-2 font-bold text-white transition hover:bg-y_premier"><i
                                    class="fa-solid fa-download mr-2"></i>Download</button>
                        </div>
                    </form>
                </div>
            @endsection
