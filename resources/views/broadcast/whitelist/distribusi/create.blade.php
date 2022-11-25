@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Distribusi Whitelist</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('whitelist.distribusi.store') }}" method="POST" class="">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                        <div class="w-full">
                            <label class="block text-gray-700" for="cluster">Cluster</label>
                            <select name="cluster" id="cluster" class="w-full rounded-md" required>
                                <option value="" selected disabled>Pilih Cluster</option>
                                @foreach ($cluster as $item)
                                <option value="{{ $item->cluster }}" {{ old('cluster')==$item->cluster?'selected':'' }}>{{ $item->cluster }}</option>
                                @endforeach
                            </select>
                            @error('cluster')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- <div class="w-full">
                            <label class="block text-gray-700" for="program">Jenis</label>
                            <select name="jenis" id="jenis" class="w-full rounded-md" required>
                                <option value="" selected disabled>Pilih Jenis</option>
                                <option value="broadcast">Broadcast</option>
                                <option value="call">Call</option>
                            </select>
                            @error('jenis')
                            <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <div class="w-full">
                        <label class="block text-gray-700" for="program">Program</label>
                        <select name="program" id="program" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih Program</option>
                            @foreach ($dataProgram as $item)
                            <option value="{{ $item->program }}" {{ old('program')==$item->program?'selected':'' }} class="program">{{ $item->program }}</option>
                            @endforeach
                        </select>
                        @error('program')
                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700" for="role">Role</label>
                        <select name="role" id="role" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih Role</option>
                            @foreach ($dataRole as $item)
                            <option value="{{ $item->role }}" {{ old('role')==$item->role?'selected':'' }} class="role">{{ $item->role }}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700" for="user">User</label>
                        <select name="user" id="user" class="w-full rounded-md" required>
                            <option value="" selected disabled>Pilih User</option>
                        </select>
                        @error('user')
                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700" for="jumlah">Jumlah Limit</label>
                        <input type="number" name="jumlah" id="jumlah" class="w-full rounded" required>
                        @error('jumlah')
                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
            </div>

            <div class="flex justify-end mt-4">
                <button class="w-full px-4 py-2 font-bold text-white bg-orange-600 rounded-md hover:bg-orange-700 focus:outline-none focus:bg-orange-700">Submit</button>
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

        $("#cluster").on('change', () => {
            var cluster = $("#cluster").val();
            var role = $("#role").val();
            console.log($(this).attr('id'));

            // if ($(this).attr('id') == 'cluster' || $(this).attr('id') == 'role') {
            console.log('aa');
            $.ajax({
                url: "{{ route('whitelist.distribusi.user') }}"
                , method: "GET"
                , dataType: "JSON"
                , data: {
                    cluster: cluster
                    , role: role
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data);
                    if (data.length) {
                        $("#user").html(
                            `<option value="" disabled selected>Pilih User</option>` +
                            data.map((item) => {
                                return `
                                    <option value="${item.telp}">${item.nama}</option>
                                    `
                            })
                        )
                    } else {
                        $("#user").html(
                            `<option value="" disabled selected>Pilih User</option>` +
                            `<option value="" disabled selected>Tidak ada user</option>`
                        )
                    }
                }
                , error: (e) => {
                    console.log(e)
                }
            });
            // }
        })

        $("#role").on('change', () => {
            var cluster = $("#cluster").val();
            var role = $("#role").val();
            console.log($(this).attr('id'));

            // if ($(this).attr('id') == 'cluster' || $(this).attr('id') == 'role') {
            console.log('aa');
            $.ajax({
                url: "{{ route('whitelist.distribusi.user') }}"
                , method: "GET"
                , dataType: "JSON"
                , data: {
                    cluster: cluster
                    , role: role
                    , _token: "{{ csrf_token() }}"
                }

                , success: (data) => {
                    console.log(data);
                    if (data.length) {
                        $("#user").html(
                            data.map((item) => {
                                `<option value="" disabled selected>Pilih User</option>`
                                return `
                                    <option value="${item.telp}">${item.nama}</option>
                                    `
                            })
                        )
                    } else {
                        $("#user").html(
                            `<option value="" disabled selected>Pilih User</option>` +
                            `<option value="" disabled selected>Tidak ada user</option>`
                        )
                    }
                }
                , error: (e) => {
                    console.log(e)
                }
            });
            // }
        })


    })

</script>
@endsection
