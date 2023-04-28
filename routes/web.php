<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [VideoController::class, 'latest'])->name('index');

Route::get('/channels', [ChannelController::class, 'index'])->name('channel.index');
Route::get('/channels/{channel}/show', [ChannelController::class, 'show'])->name('channel.show');
Route::post('/channels/search', [ChannelController::class, 'search'])->name('channel.search');
Route::get('/channels/{channel}/update-videos', [ChannelController::class, 'updateVideos'])->name('channel.updateVideos');
Route::get('/channels/update-all', [ChannelController::class, 'updateAll'])->name('channel.updateAll');
Route::get('/channels/load-from-file', [ChannelController::class, 'loadChannelsFromFile'])->name('channel.loadFromFile');
Route::post('/channels/load-from-file/post', [ChannelController::class, 'loadChannelsFromFilePost'])->name('channel.loadFromFilePost');

Route::get('/video/{video}/show', [VideoController::class, 'show'])->name('video.show');
Route::get('/video/new-videos', [VideoController::class, 'newVideos'])->name('video.newVideos');
Route::get('/video/{video}/mark-as-watched', [VideoController::class, 'markAsWatched'])->name('video.markAsWatched');
Route::get('/video/mark-all-watched', [VideoController::class, 'markAllAsWatched'])->name('video.markAllAsWatched');
