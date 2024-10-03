@extends('layouts.dashboard.app', ['plain' => true, 'title' => 'Report Trade In MYTSEL'])
@section('body')
    <section class="flex h-full min-h-screen w-full flex-col items-center bg-premier px-4 py-4">
        <span class="mb-6 mt-2 inline-block w-full text-left font-bold text-white">Report Trade In MYTSEL
            <br>
            <div class="flex gap-x-1 pt-2">
                <span>by</span>
                <div class="mt1 h-fit rounded bg-white p-1">
                    <img src="{{ asset('images/logo-new-text.png') }}" alt="Logo Youth Apps" class="h-4">
                </div>
            </div>
        </span>
        @if (request()->get('telp') && $user)
            <div class="my-4 h-fit w-full rounded-lg bg-red-400 px-4 py-2 shadow-xl sm:w-3/4">
                <span class="inline-block w-full text-left font-bold text-white">Halo, {{ $user->nama }} 👋🏻</span>
                <span class="mt-1 inline-block w-full text-left text-sm text-gray-100">The pages of yesterday cant be
                    revised,
                    but
                    u
                    hold pen to pages of tomorrow <br>
                    Semangattt Pagiii <br> Semangattt Berprestasi ⭐ 💪</span>
            </div>
        @endif
        <div class="my-4 h-fit w-full rounded-lg bg-white px-4 py-2 shadow-xl sm:w-3/4">
            @if (request()->get('telp'))
                @if (!$user)
                    <span class="inline-block w-full text-center font-bold text-slate-600">User Tidak Ditemukan</span>
                    <a href="{{ route('sales.get_refferal_mytsel') }}"
                        class="mx-auto my-2 block w-fit rounded bg-sekunder px-4 py-2 font-semibold text-white transition-all hover:bg-black">
                        <i class="fa-solid fa-arrow-left-long mr-2"></i>Kembali
                    </a>
                @else
                    <span class="inline-block w-full text-center font-bold text-slate-500">Report Trade In Mytsel</span>
                    <form action="{{ route('sales.store_refferal_mytsel') }}" method="post">
                        @csrf
                        <input type="hidden" name="telp" value="{{ $user->telp }}">
                        <input class="form-input mt-4 w-full rounded-md placeholder:text-sm focus:border-sekunder"
                            type="number" name="msisdn" id="msisdn" placeholder="Nomor Trade In (628xxx)*"
                            value="{{ old('msisdn') }}" required>
                        @error('msisdn')
                            <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <input class="form-input mt-4 w-full rounded-md placeholder:text-sm focus:border-sekunder"
                            type="number" name="kompetitor" id="kompetitor" placeholder="Nomor Kompetitor (628xxx)*"
                            value="{{ old('kompetitor') }}" required>
                        @error('kompetitor')
                            <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <select name="paket" id="paket"
                            class="form-input mt-4 w-full rounded-md focus:border-sekunder" required>
                            <option value="" selected disabled>Pilih Paket*</option>
                            @foreach ($paket as $d)
                                <option value="{{ $d->paket }}" {{ old('paket') == $d->paket ? 'selected' : '' }}>
                                    {{ $d->paket }}</option>
                            @endforeach
                        </select>
                        @error('paket')
                            <span class="mt-1 block text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                        <button type="submit" id="btn-submit"
                            class="my-2 w-full rounded bg-premier px-6 py-2 font-semibold text-white">Submit</button>
                        <a href="{{ route('sales.get_refferal_mytsel') }}"
                            class="my-1 inline-block w-full rounded bg-gray-400 px-6 py-2 text-center font-semibold text-white hover:bg-gray-600">Kembali</a>
                    </form>
                @endif
            @else
                <form action="{{ route('sales.get_refferal_mytsel') }}" method="get">
                    <span class="font-semibold text-sekunder">Telepon Agent</span>
                    <input class="form-input mt-2 w-full rounded-md focus:border-premier" type="number" name="telp"
                        id="telp" placeholder="Masukkan Telepon / USER ID Agent (812345xxxx)"
                        value="{{ old('telp') }}" required>
                    <button type="submit" id="btn-submit"
                        class="my-4 w-full rounded bg-premier px-6 py-2 font-semibold text-white">Submit</button>
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
