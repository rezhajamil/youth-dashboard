<?php

use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::resource('thread', ThreadController::class);
Route::name('thread.')->prefix('thread')->group(function () {
    Route::post('vote', [ThreadController::class, 'vote'])->name('vote');
    Route::post('comment/store', [ThreadController::class, 'store_comment'])->name('comment.store');
    Route::post('comment/store/api', [ThreadController::class, 'store_comment_api'])->name('comment.store.api');
    Route::post('vote/api', [ThreadController::class, 'vote_api'])->name('vote.api');
});
