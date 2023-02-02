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

    <link rel="icon" href="{{ asset("images/logo-shape-text.png") }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- <link rel="icon" href="{{ asset('images/mosque.svg') }}"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://kit.fontawesome.com/b2ba1193ce.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="flex flex-col items-center justify-center h-screen px-6 bg-gray-200">
        <img src="{{ asset('images/logo-new-full.png') }}" alt="" class="h-40 mb-4 aspect-auto wow fadeInDown" data-wow-duration="2s">
        <div class="w-3/4 p-6 bg-white rounded-md shadow-md">
            <div class="flex items-center justify-center">
                <span class="text-2xl font-semibold text-gray-700">Register Dashboard</span>
            </div>

            <form class="grid grid-cols-2 gap-3 mt-4" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="grid grid-cols-3 col-span-full gap-x-4">
                    <label class="block">
                        <span class="text-sm text-gray-700">Username</span>
                        <input type="text" class="block w-full mt-1 rounded-md form-input focus:border-y_premier" name="username" value="{{old('username')}}">
                        @error('username')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
    
                    <label class="block">
                        <span class="text-sm text-gray-700">Nama</span>
                        <input type="text" class="block w-full mt-1 rounded-md form-input focus:border-y_premier" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
                    
                    <label class="block">
                        <span class="text-sm text-gray-700">Role</span>
                        <select name="role" id="role" class="w-full rounded-md">
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="branch">Branch</option>
                            <option value="cluster">Cluster</option>
                        </select>
                        @error('role')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                {{-- <label class="block">
                    <span class="text-sm text-gray-700">ID Branch</span>
                    <input type="text" class="block w-full rounded-md form-input focus:border-y_premier" name="id_branch" value="{{old('id_branch',0)}}">
                    @error('id_branch')
                    <span class="text-sm italic text-premier">{{ $message }}</span>
                    @enderror
                </label> --}}


                <div class="grid grid-cols-3 col-span-full gap-x-4">
                    <label class="block">
                        <span class="text-sm text-gray-700">Region</span>
                        <select name="region" id="region" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih Region</option>
                            @foreach ($region as $item)
                            <option value="{{ $item->regional }}">{{ strtoupper($item->regional) }}</option>
                            @endforeach
                        </select>
                        @error('region')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
    
                    <label class="block">
                        <span class="text-sm text-gray-700">Branch</span>
                        <select name="branch" id="branch" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih Branch</option>
                        </select>
                        @error('branch')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
    
                    <label class="block">
                        <span class="text-sm text-gray-700">Cluster</span>
                        <select name="cluster" id="cluster" class="w-full rounded-md">
                            <option value="" selected disabled>Pilih Cluster</option>
                        </select>
                        @error('cluster')
                        <span class="text-sm italic text-premier">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
                <label class="block mt-3">
                    <span class="text-sm text-gray-700">Password</span>
                    <input type="password" class="block w-full mt-1 rounded-md form-input focus:border-y_premier" name="password">
                    @error('password')
                    <span class="text-sm italic text-premier">{{ $message }}</span>
                    @enderror
                </label>
                
                <label class="block mt-3">
                    <span class="text-sm text-gray-700">Konfirmasi Password</span>
                    <input type="password" class="block w-full mt-1 rounded-md form-input focus:border-y_premier" name="password_confirmation">
                    @error('password')
                    <span class="text-sm italic text-premier">{{ $message }}</span>
                    @enderror
                </label>

                <div class="mt-6 col-span-full">
                    <button class="w-full px-4 py-2 text-sm text-center text-white transition-all rounded-md bg-y_premier hover:bg-y_sekunder">
                        Daftar
                    </button>
                    <a href="{{route('login')}}" class="inline-block w-full mt-2 text-sm text-center underline transition cursor-pointer text-y_premier hover:text-y_premier">Sudah punya akun? Login ke akun anda</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            new WOW().init();

            $("#region").on('input', () => {
            var regional = $("#region").val();
            console.log(regional)
            $.ajax({
                url: "{{ route('wilayah.get_branch') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    regional: regional
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    $("#branch").html(
                        "<option disabled selected>Pilih Branch</option>"+
                        data.map((item) => {
                            return `
                            <option value="${item.branch}">${item.branch}</option>
                            `
                        })

                    )
                }
                , error: (e) => {
                    console.log(e)
                }
            });

        })

        $("#branch").on('input', () => {
            var branch = $("#branch").val();
            console.log(branch)
            $.ajax({
                url: "{{ route('wilayah.get_cluster') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    branch: branch
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    $("#cluster").html(
                        "<option selected disabled>Pilih Cluster</option>"+ 
                        data.map((item) => {
                            return `
                    <option value="${item.cluster}">${item.cluster}</option>
                    `
                        })

                    )

                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })
        });

    </script>
</body>
</html>
