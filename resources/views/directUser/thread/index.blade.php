@extends('layouts.dashboard.app', ['plain' => true])
@section('body')
    <section class="flex flex-col w-full h-full min-h-screen px-2 py-4 bg-gray-100">
        <div class="flex items-center justify-center w-full mb-4 gap-x-2">
            <img src="{{ asset('images/logo-new.png') }}" alt="Logo Yout" class="h-10">
            <span
                class="text-2xl font-bold text-transparent bg-gradient-to-br from-y_premier to-y_tersier font-batik bg-clip-text">Threads</span>
        </div>
        <div class="w-full mb-2">
            <div class="relative right-0">
                <ul class="relative flex flex-wrap p-1 list-none rounded shadow-sm bg-gray-300/50" data-tabs="tabs"
                    role="list">
                    <li class="z-30 flex-auto text-center">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'populer']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ !$tab || $tab == 'populer' ? 'tab-active' : '' }}"
                            data-tab-target="" active role="tab" aria-selected="true">
                            <span class="ml-1">Populer</span>
                        </a>
                    </li>
                    <li class="z-30 flex-auto text-center">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'terbaru']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ $tab == 'terbaru' ? 'tab-active' : '' }}"
                            data-tab-target="" role="tab" aria-selected="false">
                            <span class="ml-1">Terbaru</span>
                        </a>
                    </li>
                    <li class="z-30 flex-auto text-center">
                        <a href="{{ route('thread.index', ['telp' => Request::get('telp') ?? '', 'tab' => 'saya']) }}"
                            class="z-30 flex items-center justify-center w-full px-0 py-1 mb-0 font-semibold transition-all ease-in-out border-0 rounded cursor-pointer text-slate-700/60 bg-inherit {{ $tab == 'saya' ? 'tab-active' : '' }}"
                            data-tab-target="" role="tab" aria-selected="false">
                            <span class="ml-1">Thread Saya</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col w-full gap-2 py-2">
            @forelse ($threads as $key=>$thread)
                <div class="w-full px-3 py-2 bg-white rounded shadow-lg h-fit">
                    <div class="flex justify-between mb-2">
                        <div class="flex flex-col">
                            <span
                                class="text-sm font-semibold text-gray-500">{{ ucwords(strtolower($thread->user->nama)) }}</span>
                            <span class="text-[10px] text-gray-400">{{ $thread->user->cluster }}</span>
                        </div>
                        <div class="flex items-start gap-x-3">
                            <span class="text-gray-600 text-[10px]">{{ $thread->time }}</span>
                            <span class="text-xs font-semibold">
                                <i class="fa-solid fa-star text-y_tersier"></i>
                                {{ $thread->vote }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-1 border-b">
                        <p class="">{!! $thread->message !!}</p>
                    </div>
                    <div class="flex mb-2 gap-x-2">
                        <form action="{{ route('thread.vote') }}" method="post">
                            @csrf
                            <input type="hidden" name="telp" value="{{ $user->telp }}">
                            <input type="hidden" name="thread" value="{{ $thread->id }}">
                            <input type="hidden" name="type" value="up">
                            <button id="btn-up-{{ $thread->id }}"
                                class="px-2 py-1 font-semibold rounded text-y_premier hover:bg-y_premier hover:text-white">
                                <i class="fa-solid fa-square-caret-up"></i>
                                <span class="text-sm">Up</span>
                            </button>
                        </form>
                        <form action="{{ route('thread.vote') }}" method="post">
                            @csrf
                            <input type="hidden" name="telp" value="{{ $user->telp }}">
                            <input type="hidden" name="thread" value="{{ $thread->id }}">
                            <input type="hidden" name="type" value="down">
                            <button id="btn-down-{{ $thread->id }}"
                                class="px-2 py-1 font-semibold rounded text-y_tersier hover:bg-y_tersier hover:text-white">
                                <i class="fa-solid fa-square-caret-down"></i>
                                <span class="text-sm">Down</span>
                            </button>
                        </form>
                        <button id="btn-comment{{ $thread->id }}" thread="{{ $thread->id }}"
                            class="px-2 py-1 font-semibold rounded text-y_sekunder hover:bg-y_sekunder hover:text-white btn-comment">
                            <i class="fa-solid fa-comment-dots"></i>
                            <span class="text-sm">Comment</span>
                        </button>
                    </div>
                    @if (count($thread->comments))
                        <div class="flex flex-col hidden px-3" id="comment-{{ $thread->id }}">
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
                    @endif
                    <form action="{{ route('thread.comment.store') }}" method="POST"
                        id="form-comment-{{ $thread->id }}" class="flex hidden w-full mt-1">
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
            @empty
                <div class="flex flex-col items-center justify-center w-full py-6">
                    <i class="text-[50px] fa-solid fa-newspaper text-gray-400"></i>
                    <span class="font-bold text-gray-400 ">Tidak Ada Threads</span>
                </div>
            @endforelse
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(".btn-comment").on("click", function() {
                let thread = $(this).attr('thread');

                $(this).toggleClass('btn-comment-active');
                $(`#comment-${thread}`).toggleClass('hidden');
                $(`#form-comment-${thread}`).toggleClass('hidden');
                $([document.documentElement, document.body]).animate({
                    scrollTop: $(`#form-comment-${thread}`).offset().top
                }, 2000);
            })
        })
    </script>
@endsection
