@extends('layouts.dashboard.app', ['plain' => true])
@section('body')
    <section class="flex flex-col w-full h-full min-h-screen px-2 py-4 bg-gray-100 font-caregold">
        <div class="flex items-center justify-center w-full mb-4 gap-x-2">
            <img src="{{ asset('images/logo-new.png') }}" alt="Logo Yout" class="h-10">
            <span
                class="text-2xl font-bold text-transparent bg-gradient-to-br from-y_premier to-y_tersier font-batik bg-clip-text">Threads</span>
        </div>
        <div class="px-3 py-2 my-6 bg-white rounded-md shadow-xl">
            <form action="{{ route('thread.store') }}" class="" method="POST">
                @csrf
                <div class="flex justify-between w-full my-3">
                    <span class="inline-block w-full text-lg font-bold">Buat Thread</span>
                    <button type="submit"
                        class="px-3 py-1 text-sm font-semibold text-white transition-all rounded-md bg-gradient-to-br from-y_premier to-y_sekunder hover:to-y_tersier">Upload</button>
                </div>
                <input type="hidden" name="telp" value="{{ request()->get('telp') }}">
                <input type="hidden" name="message" id="message" value="{!! old('message') !!}">
                <trix-editor input="message" row="20"></trix-editor>
                @error('message')
                    <span class="block text-sm italic text-red-600">{{ $message }}</span>
                @enderror
            </form>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {})
    </script>
@endsection
