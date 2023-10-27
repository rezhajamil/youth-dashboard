<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="referrer" content="always">
    {{-- <link rel="canonical" href="{{ $page->getUrl() }}"> --}}

    <meta name="description" content="DASHBOARD YOUTH JAWARA">

    <title>DASHBOARD YOUTH JAWARA</title>

    <link rel="icon" href="{{ asset('images/logo-shape-text.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <link rel="icon" href="{{ asset('images/mosque.svg') }}"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://kit.fontawesome.com/b2ba1193ce.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="flex flex-col items-center justify-center h-screen px-6 bg-gray-200">
        <img src="{{ asset('images/logo-new-full.png') }}" alt="" class="h-40 mb-4 aspect-auto wow fadeInDown"
            data-wow-duration="2s">
        <div class="w-3/4 max-w-sm p-6 bg-white rounded-md shadow-md sm:w-1/2">
            <div class="flex items-center justify-center">
                <span class="text-2xl font-semibold text-gray-700">Login Dashboard</span>
            </div>

            <form class="mt-4" action="{{ route('login') }}" method="POST">
                @csrf
                <label class="block">
                    <span class="text-sm text-gray-700">Username</span>
                    <input type="text" class="block w-full mt-1 rounded-md form-input focus:border-y_premier"
                        name="username">
                </label>
                @error('username')
                    <span class="text-sm italic text-premier">{{ $message }}</span>
                @enderror

                <label class="block mt-3">
                    <span class="text-sm text-gray-700">Password</span>
                    <input type="password" class="block w-full mt-1 rounded-md form-input focus:border-y_premier"
                        name="password">
                </label>
                @error('password')
                    <span class="text-sm italic text-premier">{{ $message }}</span>
                @enderror

                <div class="flex items-center justify-between mt-4">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" checked class="text-y_premier form-checkbox">
                            <span class="mx-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    {{-- <div>
                        <a href="{{ route('password.request') }}" class="block text-sm text-sky-700 fontme hover:underline" href="#">Forgot your password?</a>
                </div> --}}
                </div>

                <div class="mt-6">
                    <button
                        class="w-full px-4 py-2 text-sm text-center text-white transition-all rounded-md bg-y_premier hover:bg-y_sekunder">
                        Sign in
                    </button>
                </div>
                <a href="{{ route('register') }}"
                    class="inline-block w-full mt-2 text-center underline transition-all text-y_premier hover:text-sky-900">Daftar</a>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            new WOW().init();
        });
    </script>
</body>

</html>
