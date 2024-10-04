@extends('layouts.dashboard.app', ['plain' => true, 'title' => 'Report Trade In Promotor / SF'])
@section('body')
    <section class="flex flex-col items-center w-full h-full min-h-screen px-4 py-4 bg-indigo-400">
        <span class="inline-block w-full mt-2 mb-6 font-bold text-left text-white">Report Trade In Promotor / SF
            <br>
            <div class="flex pt-2 gap-x-1">
                <span>by</span>
                <div class="p-1 bg-white rounded mt1 h-fit">
                    <img src="{{ asset('images/logo-new-text.png') }}" alt="Logo Youth Apps" class="h-4">
                </div>
            </div>
        </span>
        @if (request()->get('telp') && $user)
            <div class="w-full px-4 py-2 my-4 bg-indigo-600 rounded-lg shadow-xl h-fit sm:w-3/4">
                <span class="inline-block w-full font-bold text-left text-white">Halo, {{ $user->user_name }} 👋🏻</span>
                <span class="inline-block w-full mt-1 text-sm text-left text-gray-100">The pages of yesterday cant be
                    revised,
                    but
                    u
                    hold pen to pages of tomorrow <br>
                    Semangattt Pagiii <br> Semangattt Berprestasi ⭐ 💪</span>
            </div>
        @endif
        <div class="w-full px-4 py-2 my-4 bg-white rounded-lg shadow-xl h-fit sm:w-3/4">
            @if (request()->get('telp'))
                @if (!$user)
                    <span class="inline-block w-full font-bold text-center text-slate-600">User Tidak Ditemukan</span>
                    <a href="{{ route('sales.get_refferal') }}"
                        class="block px-4 py-2 mx-auto my-2 font-semibold text-white transition-all rounded w-fit bg-sekunder hover:bg-black">
                        <i class="mr-2 fa-solid fa-arrow-left-long"></i>Kembali
                    </a>
                @else
                    <span class="inline-block w-full font-bold text-center text-slate-500">Report Trade In Promotor /
                        SF</span>
                    <form action="{{ route('sales.store_refferal') }}" method="post">
                        @csrf
                        <input type="hidden" name="telp" value="{{ $user->user_id }}">
                        <input class="w-full mt-4 rounded-md form-input placeholder:text-sm focus:border-sekunder"
                            type="number" name="msisdn" id="msisdn" placeholder="Nomor Trade In (628xxx)*"
                            value="{{ old('msisdn') }}" required>
                        @error('msisdn')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <input class="w-full mt-4 rounded-md form-input placeholder:text-sm focus:border-sekunder"
                            type="number" name="kompetitor" id="kompetitor" placeholder="Nomor Kompetitor (628xxx)*"
                            value="{{ old('kompetitor') }}" required>
                        @error('kompetitor')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <select name="paket" id="paket"
                            class="w-full mt-4 rounded-md form-input focus:border-sekunder" required>
                            <option value="" selected disabled>Pilih Paket*</option>
                            @foreach ($paket as $d)
                                <option value="{{ $d->paket }}" {{ old('paket') == $d->paket ? 'selected' : '' }}>
                                    {{ $d->paket }}</option>
                            @endforeach
                        </select>
                        @error('paket')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <button type="submit" id="btn-submit"
                            class="w-full px-6 py-2 my-2 font-semibold text-white bg-indigo-800 rounded">Submit</button>
                        <a href="{{ route('sales.get_refferal') }}"
                            class="inline-block w-full px-6 py-2 my-1 font-semibold text-center text-white bg-gray-400 rounded hover:bg-gray-600">Kembali</a>
                    </form>
                @endif
            @else
                <form action="{{ route('sales.get_refferal') }}" method="get">
                    <span class="font-semibold text-sekunder">Telepon Promotor / SF</span>
                    <input class="w-full mt-2 rounded-md form-input focus:border-indigo-600" type="number" name="telp"
                        id="telp" placeholder="Masukkan Telepon / USER ID Promotor / SF (6281234xxxxx)"
                        value="{{ old('telp') }}" required>
                    <button type="submit" id="btn-submit"
                        class="w-full px-6 py-2 my-4 font-semibold text-white bg-indigo-800 rounded">Submit</button>
                </form>
            @endif
        </div>
    </section>
@endsection
@section('script')
    @if (session('success'))
        <script>
            alert('Berhasil Input Report MSISDN MyTsel')
        </script>
    @endif
@endsection
