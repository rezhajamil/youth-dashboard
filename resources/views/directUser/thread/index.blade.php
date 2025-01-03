@extends('layouts.dashboard.app', ['plain' => true])
@section('body')
    <section class="flex flex-col w-full h-full min-h-screen px-2 py-4 bg-gray-100 font-caregold">
        {{-- <div class="flex items-center justify-center w-full mb-4 gap-x-2">
            <img src="{{ asset('images/logo-new.png') }}" alt="Logo Yout" class="h-7">
            <span
                class="text-lg font-bold text-transparent bg-gradient-to-br from-y_premier to-y_tersier font-batik bg-clip-text">Threads</span>
        </div> --}}
        <div class="w-full mb-2">
            <div class="relative right-0">
                <ul class="relative flex flex-wrap p-1 list-none rounded shadow-sm bg-gray-300/50" data-tabs="tabs"
                    role="list">
                    <li class="z-30 flex-auto text-center tab-link">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'populer']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ $tab == 'populer' ? 'tab-active' : '' }}"
                            data-tab-target="" active role="tab" aria-selected="true">
                            <span class="ml-1 text-sm">Populer</span>
                        </a>
                    </li>
                    <li class="z-30 flex-auto text-center tab-link">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'terbaru']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ !$tab || $tab == 'terbaru' ? 'tab-active' : '' }}"
                            data-tab-target="" role="tab" aria-selected="false">
                            <span class="ml-1 text-sm">Terbaru</span>
                        </a>
                    </li>
                    <li class="z-30 flex-auto text-center tab-link">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'saya']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ $tab == 'saya' ? 'tab-active' : '' }}"
                            data-tab-target="" role="tab" aria-selected="false">
                            <span class="ml-1 text-sm">Thread Saya</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col w-full gap-2 py-2 mb-10">
            @forelse ($threads as $key=>$thread)
                <div class="w-full px-3 py-2 bg-white rounded shadow-lg h-fit @if (request()->get('tab') == 'saya') card @endif"
                    thread="{{ $thread->id }}">
                    <div class="flex justify-between mb-2">
                        <div class="flex flex-col">
                            <span
                                class="text-xs font-semibold text-gray-500">{{ ucwords(strtolower($thread->user->nama)) }}</span>
                            <span class="text-[10px] text-gray-400">{{ $thread->user->cluster }}</span>
                        </div>
                        <div class="flex items-start gap-x-3">
                            <span class="text-gray-600 text-[10px]">{{ $thread->time }}</span>
                            <span class="text-xs font-semibold">
                                <i class="fa-solid fa-star text-y_tersier"></i>
                                <span id="vote-{{ $thread->id }}">{{ $thread->vote }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="mb-1 border-b">
                        <p class="text-sm">{!! $thread->message !!}</p>
                    </div>
                    <div class="flex gap-x-2">
                        <form action="{{ route('thread.vote') }}" method="post" id="form-vote-up-{{ $thread->id }}"
                            thread="{{ $thread->id }}" class="form-vote">
                            @csrf
                            <input type="hidden" name="telp" value="{{ $user->telp }}">
                            <input type="hidden" name="thread" value="{{ $thread->id }}">
                            <input type="hidden" name="type" value="up">
                            <button id="btn-up-{{ $thread->id }}"
                                {{ $thread->votes && $thread->votes->type == 'up' ? 'disabled' : '' }}
                                class="px-2 py-1 font-semibold rounded text-y_premier hover:bg-y_premier hover:text-white disabled:bg-y_premier disabled:text-white btn-vote">
                                <i class="fa-solid fa-square-caret-up"></i>
                                <span class="text-xs">Up</span>
                            </button>
                        </form>
                        <form action="{{ route('thread.vote') }}" method="post" id="form-vote-down-{{ $thread->id }}"
                            thread="{{ $thread->id }}" class="form-vote">
                            @csrf
                            <input type="hidden" name="telp" value="{{ $user->telp }}">
                            <input type="hidden" name="thread" value="{{ $thread->id }}">
                            <input type="hidden" name="type" value="down">
                            <button id="btn-down-{{ $thread->id }}"
                                {{ $thread->votes && $thread->votes->type == 'down' ? 'disabled' : '' }}
                                class="px-1 py-1 font-semibold rounded text-y_tersier hover:bg-y_tersier hover:text-white disabled:bg-y_tersier disabled:text-white btn-vote">
                                <i class="fa-solid fa-square-caret-down"></i>
                                <span class="text-xs">Down</span>
                            </button>
                        </form>
                        <button id="btn-comment{{ $thread->id }}" thread="{{ $thread->id }}"
                            class="px-1 py-1 font-semibold rounded text-y_sekunder hover:bg-y_sekunder hover:text-white btn-comment">
                            <i class="fa-solid fa-comment-dots"></i>
                            <span class="text-xs tracking-wide">Comment
                                {{ count($thread->comments) ? '(' . count($thread->comments) . ')' : '' }}</span>
                        </button>
                    </div>
                    {{-- @if (count($thread->comments)) --}}
                    <div class="flex flex-col hidden px-3 mt-2" id="comment-{{ $thread->id }}">
                        @foreach ($thread->comments as $comment)
                            <div class="flex justify-between mb-1">
                                <div class="flex flex-col">
                                    <span
                                        class="text-xs font-semibold text-gray-500">{{ ucwords(strtolower($comment->user->nama)) }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $comment->user->cluster }}</span>
                                </div>
                                <div class="flex items-start gap-x-3">
                                    <span class="text-gray-600 text-[10px]">{{ $comment->time }}</span>
                                </div>
                            </div>
                            <div class="mb-2 border-b">
                                <p class="text-sm">{!! $comment->message !!}</p>
                            </div>
                        @endforeach
                    </div>
                    {{-- @endif --}}
                    <span class="block w-full my-2 text-center text-y_tersier" id="loading-comment-{{ $thread->id }}"
                        style="display: none">
                        <i class="fa-solid fa-spinner animate-spin"></i>
                    </span>
                    <form action="{{ route('thread.comment.store') }}" method="POST"
                        id="form-comment-{{ $thread->id }}" class="flex hidden w-full mt-1 form-comment"
                        thread="{{ $thread->id }}">
                        @csrf
                        <input type="hidden" name="thread" value="{{ $thread->id }}">
                        <input type="hidden" name="telp" value="{{ $user->telp }}">
                        <input type="text" name="message" id="message-{{ $thread->id }}"
                            class="w-11/12 px-2 py-1 text-sm border-0 border-b rounded bg-gray-100/30 focus:shadow-none focus:ring-0 focus:border-b-y_premier placeholder:text-sm"
                            placeholder="Berikan komentar untuk {{ ucwords(strtolower($thread->user->nama)) }}" required>
                        <button type="submit" class="w-1/12 text-lg text-right hover:text-y_sekunder text-y_premier">
                            <i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
                @if (request()->get('tab') == 'saya')
                    <div class="fixed inset-0 z-20 flex items-center justify-center w-full h-full bg-white/60"
                        id="action-modal-{{ $thread->id }}" style="display: none">
                        <div class="w-2/3 px-4 py-4 bg-white rounded-md shadow-xl">
                            <span class="inline-block mb-6 font-semibold">Hapus Thread?</span>
                            <div class="flex items-end justify-between gap-x-3">
                                <span class="font-semibold text-gray-400 cursor-pointer cancel-modal"
                                    thread="{{ $thread->id }}">Cancel
                                </span>
                                <form action="{{ route('thread.destroy', $thread->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="px-3 py-1 font-semibold text-white rounded-md bg-y_tersier">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="flex flex-col items-center justify-center w-full py-6">
                    <i class="text-[50px] fa-solid fa-newspaper text-gray-400"></i>
                    <span class="font-bold text-gray-400 ">Tidak Ada Threads</span>
                </div>
            @endforelse
        </div>
        {{-- <a href="{{ route('thread.create', ['telp' => request()->get('telp')]) }}"
            class="fixed flex items-center justify-center px-4 py-3 text-white transition-all rounded-full shadow-2xl hover:to-y_tersier right-4 bottom-3 bg-gradient-to-br from-y_premier to-y_sekunder aspect-square">
            <i class="text-2xl fa-solid fa-pen-to-square"></i>
        </a> --}}
    </section>
    <div class="fixed inset-0 z-30 flex items-center justify-center w-full h-full bg-white/60" id="loading-page"
        style="display: none">
        <img src="{{ asset('images/loading.svg') }}" alt="Loading" class="block">
    </div>
    @if (session('success'))
        <div id="session-alert"
            class="fixed inset-x-0 flex items-center justify-between px-3 py-2 ml-3 mr-auto rounded-md shadow-2xl bg-gradient-to-br to-y_tersier from-pink-600 drop-shadow-2xl w-fit bottom-3">
            <span class="font-semibold text-white">{{ session('success') ?? 'Berhasil Menghapus Thread' }}</span>
            <i class="ml-3 text-lg text-white fa-solid fa-circle-xmark" id="close-session-alert"></i>
        </div>
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var longClickTimeout;
            $(".btn-comment").on("click", function() {
                let thread = $(this).attr('thread');

                $(this).toggleClass('btn-comment-active');
                $(`#comment-${thread}`).toggleClass('hidden');
                $(`#form-comment-${thread}`).toggleClass('hidden');
                // $([document.documentElement, document.body]).animate({
                //     scrollTop: $(`#form-comment-${thread}`).offset().top
                // }, 2000);
            });

            $(".tab-link").on("click", function() {
                $("#loading-page").show();
            })

            $(".card").on("mousedown", function() {
                let thread = $(this).attr('thread');
                longClickTimeout = setTimeout(function() {
                    // Long click event handler
                    $(`#action-modal-${thread}`).show();
                    console.log('asda');
                    console.log(thread);
                    console.log($(`#action-modal-${thread}`));

                }, 500); // Change the timeout value to adjust the long click duration
            }).on("mouseup mouseleave", function() {
                clearTimeout(longClickTimeout);
            });

            $(".card").on("touchstart", function(e) {
                let thread = $(this).attr('thread');
                e.preventDefault();
                longClickTimeout = setTimeout(function() {
                    // Long click event handler
                    $(`#action-modal-${thread}`).show();
                    console.log('asda');
                    console.log(thread);
                    console.log($(`#action-modal-${thread}`));

                }, 500); // Change the timeout value to adjust the long click duration
            }).on("touchend touchcancel", function() {
                clearTimeout(longClickTimeout);
            });

            $(".cancel-modal").click(function() {
                let thread = $(this).attr('thread');
                $(`#action-modal-${thread}`).hide();
            })

            $("#close-session-alert").click(function() {
                $("#session-alert").hide();
            })

            $(".form-comment").on("submit", function() {
                let thread = $(this).attr('thread');
                let comment_section = $(`#comment-${thread}`);
                let loading = $(`#loading-comment-${thread}`);
                event.preventDefault();
                loading.show();

                var formData = $(this).serialize();
                var parsedData = {};

                new URLSearchParams(formData).forEach(function(value, key) {
                    parsedData[key] = value;
                });

                try {
                    storeComment(parsedData, comment_section, loading);
                } catch (error) {
                    alert(error);
                }

                $(`#message-${thread}`).val("");
                // console.log(formData);
                // console.log(parsedData);
            });

            $(".form-vote").on("submit", function() {
                let thread = $(this).attr('thread');
                let vote = $(`#vote-${thread}`);
                event.preventDefault();

                var formData = $(this).serialize();
                var parsedData = {};

                new URLSearchParams(formData).forEach(function(value, key) {
                    parsedData[key] = value;
                });
                $(`#btn-${parsedData.type}-${thread}`).attr('disabled', true);
                let btn_up = $(`#btn-up-${thread}`);
                let btn_down = $(`#btn-down-${thread}`);

                try {
                    storeVote(parsedData, btn_up, btn_down, vote);
                } catch (error) {
                    $(`#btn-${parsedData.type}-${thread}`).attr('disabled', false);
                    alert(error);
                }

                $(`#message-${thread}`).val("");
                // console.log(formData);
                // console.log(parsedData);
            });

            const storeComment = (formData, comment = null, loading = null) => {
                $.ajax({
                    url: "{{ route('thread.comment.store.api') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        thread: formData.thread,
                        message: formData.message,
                        telp: formData.telp,
                        _token: formData._token,
                    },
                    success: (data) => {
                        console.log(data);
                        let comment_card =
                            `<div class="flex justify-between mb-1">
                            <div class="flex flex-col">
                                <span
                                    class="text-xs font-semibold text-gray-500">{{ ucwords(strtolower($user->nama)) }}</span>
                                <span class="text-[10px] text-gray-400">{{ $user->cluster }}</span>
                            </div>
                            <div class="flex items-start gap-x-3">
                                <span class="text-gray-600 text-[10px]">1 menit yang lalu</span>
                            </div>
                        </div>
                        <div class="mb-2 border-b">
                            <p class="text-sm">${formData.message}</p>
                        </div>`;

                        comment.append(comment_card);
                        loading.hide();
                    },
                    error: (e) => {
                        alert("Gagal mengupload komentar");
                        console.log(e)
                    }
                });
            }

            const storeVote = (formData, btnUp = null, btnDown = null, vote = null) => {
                $.ajax({
                    url: "{{ route('thread.vote.api') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        thread: formData.thread,
                        type: formData.type,
                        telp: formData.telp,
                        _token: formData._token,
                    },
                    success: (data) => {
                        // console.log(data);
                        if (formData.type == 'up') {
                            btnUp.attr('disabled', true);
                            btnDown.attr('disabled', false);
                        } else if (formData.type == 'down') {
                            btnUp.attr('disabled', false);
                            btnDown.attr('disabled', true);
                        }

                        vote.text(data.vote);
                    },
                    error: (e) => {
                        alert("Gagal Vote");
                        console.log(e)
                    }
                });
            }
        })
    </script>
@endsection
