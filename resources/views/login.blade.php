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

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <link rel="icon" href="{{ asset('images/mosque.svg') }}"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/b2ba1193ce.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="flex justify-center items-center h-screen bg-gray-200 px-6">
        <div class="p-6 max-w-sm bg-white shadow-md rounded-md w-1/2">
            <div class="flex justify-center items-center">
                <span class="text-gray-700 font-semibold text-2xl">Dashboard</span>
            </div>

            <form class="mt-4" action="{{ route('login') }}" method="POST">
                @csrf
                <label class="block">
                    <span class="text-gray-700 text-sm">Username</span>
                    <input type="text" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="username">
                </label>

                <label class="block mt-3">
                    <span class="text-gray-700 text-sm">Password</span>
                    <input type="password" class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" name="password">
                </label>

                <div class="flex justify-between items-center mt-4">
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-indigo-600">
                            <span class="mx-2 text-gray-600 text-sm">Remember me</span>
                        </label>
                    </div>

                    <div>
                        <a href="{{ route('password.request') }}" class="block text-sm fontme text-indigo-700 hover:underline" href="#">Forgot your password?</a>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
