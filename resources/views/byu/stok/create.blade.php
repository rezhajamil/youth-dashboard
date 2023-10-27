@extends('layouts.dashboard.app')
@section('body')
    <div class="w-full mx-4">
        <div class="flex flex-col">
            <div class="mt-4">
                <a href="{{ route('byu.index') }}"
                    class="inline-block px-4 py-2 font-bold text-white transition-all rounded-md bg-y_premier hover:bg-y_premier"><i
                        class="mr-2 fa-solid fa-arrow-left"></i> Kembali</a>
                <a href="{{ route('byu.stok.view') }}" target="_blank"
                    class="inline-block px-4 py-2 my-2 font-bold text-white rounded-md bg-y_tersier hover:bg-y_tersier"><i
                        class="mr-2 fa-solid fa-list"></i> Hasil Input Stok ByU Legacy</a>
                <h4 class="my-4 text-xl font-bold text-gray-600 align-baseline">Permintaan Tambahan Stok ByU Legacy</h4>

                <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                    <form action="{{ route('byu.store') }}" method="POST" class="">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div class="w-full">
                                <label class="block text-gray-700" for="cluster">Cluster</label>
                                <select name="cluster" id="cluster" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih Cluster</option>
                                    @foreach ($cluster as $item)
                                        <option value="{{ $item->cluster }}"
                                            {{ old('cluster') == $item->cluster ? 'selected' : '' }}>
                                            {{ $item->cluster }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cluster')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full">
                                <label class="block text-gray-700" for="city">City</label>
                                <select name="city" id="city" class="w-full rounded-md">
                                    <option value="" selected disabled>Pilih City</option>
                                </select>
                                @error('city')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="date">Tanggal</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="date"
                                    name="date" value="{{ old('date') }}">
                                @error('date')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="text-gray-700" for="jumlah">Jumlah</label>
                                <input class="w-full rounded-md form-input focus:border-indigo-600" type="number"
                                    name="jumlah" placeholder="Jumlah" value="{{ old('jumlah') }}">

                                @error('jumlah')
                                    <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button
                                class="w-full px-4 py-2 font-bold text-white rounded-md bg-y_premier hover:bg-y_sekunder focus:outline-none focus:bg-y_sekunder">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#cluster").on('input', () => {
                var cluster = $("#cluster").val();
                console.log(cluster)
                $.ajax({
                    url: "{{ route('wilayah.get_lbo_city') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        cluster: cluster,
                        _token: "{{ csrf_token() }}"
                    },
                    success: (data) => {
                        console.log(data)
                        $("#city").html(
                            "<option selected disabled>Pilih City</option>" +
                            data.map((item) => {
                                return `
                    <option value="${item.kabupaten}">${item.kabupaten}</option>
                    `
                            })

                        )

                    },
                    error: (e) => {
                        console.log(e)
                    }
                })
            })
        })
    </script>
@endsection
