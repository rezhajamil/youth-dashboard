@extends('layouts.dashboard.app', ['plain' => true, 'title' => 'Refferal Reporting Program'])
@section('body')
    <section class="flex flex-col items-center w-full h-full min-h-screen px-4 py-4 bg-indigo-400">
        <span class="inline-block w-full mt-2 mb-6 font-bold text-left text-white">Refferal Reporting Program
            <br>
            <div class="flex pt-2 gap-x-1">
                <span>by</span>
                <div class="p-1 bg-white rounded h-fit mt1">
                    <img src="{{ asset('images/logo-new-text.png') }}" alt="Logo Youth Apps" class="h-4">
                </div>
            </div>
        </span>
        @if (request()->get('nik') && $user)
            <div class="w-full px-4 py-2 my-4 bg-indigo-600 rounded-lg shadow-xl h-fit sm:w-3/4">
                <span class="inline-block w-full font-bold text-left text-white">Halo, {{ $user->name }} 👋🏻</span>
                <span class="inline-block w-full mt-1 text-sm text-left text-gray-100">The pages of yesterday cant be
                    revised,
                    but
                    u
                    hold pen to pages of tomorrow <br>
                    Semangattt Pagiii <br> Semangattt Berprestasi ⭐ 💪</span>
            </div>
        @endif
        <div class="w-full px-4 py-2 my-4 bg-white rounded-lg shadow-xl h-fit sm:w-3/4 ">
            @if (request()->get('nik'))
                @if (!$user)
                    <span class="inline-block w-full font-bold text-center text-slate-600">NIK User Tidak Ditemukan</span>
                    <a href="{{ route('sales.get_refferal') }}"
                        class="block px-4 py-2 mx-auto my-2 font-semibold text-white transition-all rounded bg-sekunder w-fit hover:bg-black">
                        <i class="mr-2 fa-solid fa-arrow-left-long"></i>Kembali
                    </a>
                @else
                    <span class="inline-block w-full font-bold text-center text-slate-500">Report MSISDN MyTsel</span>
                    <form action="{{ route('sales.store_refferal') }}" method="post">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="nik" value="{{ $user->nik_siad }}">
                        <input class="w-full mt-4 rounded-md form-input focus:border-sekunder placeholder:text-sm"
                            type="number" name="msisdn" id="msisdn" placeholder="MSISDN (628xxx)*"
                            value="{{ old('msisdn') }}" required>
                        @error('msisdn')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        {{-- <select name="program" id="program"
                            class="w-full mt-4 rounded-md form-input focus:border-sekunder" required>
                            <option value="" selected disabled>Pilih Program*</option>
                            <option value="mytsel">My Telkomsel</option>
                        </select>
                        @error('program')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <input class="w-full mt-4 rounded-md form-input focus:border-sekunder" type="text" name="paket"
                            id="paket" placeholder="PAKET" value="{{ old('paket') }}">
                        @error('paket')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror --}}
                        <button type="submit" id="btn-submit"
                            class="w-full px-6 py-2 my-2 font-semibold text-white bg-indigo-800 rounded">Submit</button>
                        <a href="{{ route('sales.get_refferal') }}"
                            class="inline-block w-full px-6 py-2 my-1 font-semibold text-center text-white bg-gray-400 rounded hover:bg-gray-600 ">Kembali</a>
                    </form>
                @endif
            @else
                <form action="{{ route('sales.get_refferal') }}" method="get">
                    <span class="font-semibold text-sekunder">NIK SIAD User Refferal</span>
                    <input class="w-full mt-2 rounded-md form-input focus:border-indigo-600" type="number" name="nik"
                        id="nik" placeholder="Masukkan NIK SIAD" value="{{ old('nik') }}" required>
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
