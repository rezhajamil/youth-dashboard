@extends('layouts.dashboard.app')
@section('body')
<div class="w-full mx-4">
    <div class="flex flex-col">
        <div class="mt-4">
            <h4 class="text-xl font-bold text-gray-600 align-baseline">Tambah Data Whitelist</h4>

            <div class="px-6 py-4 mx-auto overflow-auto bg-white rounded-md shadow sm:mx-0 w-fit">
                <form action="{{ route('whitelist.store') }}" method="POST" class="" enctype="multipart/form-data">
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
                        <label class="text-gray-700" for="file">File</label>
                        <label class="block text-xs text-gray-700" for="file">File dengan format .csv</label>
                        <label class="block text-xs text-gray-700" for="file">Format 'msisdn|site_id -> 628xxxxxxxxxxx|xx'</label>
                        <label class="block text-xs text-gray-700" for="file">File maksimal 500 baris</label>
                        <input class="w-full rounded-md form-input focus:border-indigo-600" type="file" name="file" value="{{ old('file') }}">
                        @error('file')
                        <span class="block mt-1 text-sm italic text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
            </div>

            <div class="flex justify-end mt-4">
                <button class="w-full px-4 py-2 font-bold text-white bg-indigo-800 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Submit</button>
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

        $("#regional").on('input', () => {
            var regional = $("#regional").val();
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

        $("#cluster").on('input', () => {
            var cluster = $("#cluster").val();
            console.log(cluster)
            $.ajax({
                url: "{{ route('wilayah.get_tap') }}"
                , method: "POST"
                , dataType: "JSON"
                , data: {
                    cluster: cluster
                    , _token: "{{ csrf_token() }}"
                }
                , success: (data) => {
                    console.log(data)
                    $("#tap").html(
                        data.map((item) => {
                            return `
                    <option value="${item.nama}">${item.nama}</option>
                    `
                        })

                    )

                }
                , error: (e) => {
                    console.log(e)
                }
            })
        })

        $("select[name=jenis]").on("change", function() {
            let value = $(this).val();

            if (value == 'broadcast') {
                $(".program").show();
                $(".program_call").hide();
            } else if (value == 'call') {
                $(".program").hide();
                $(".program_call").show();
            } else {
                $(".program").hide();
                $(".program_call").hide();
            }
        })

    })

</script>
@endsection
