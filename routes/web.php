<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FrontpageController;
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
Route::get('/channel/show/{channel_id}', [ChannelController::class, 'show'])->name('channel.show');
Route::post('/channel/search', [ChannelController::class, 'search'])->name('channel.search');
Route::get('/channel/update-videos/{channel_id}', [ChannelController::class, 'updateVideos'])->name('channel.updateVideos');
Route::get('/channel/update-all', [ChannelController::class, 'updateAll'])->name('channel.updateAll');
Route::get('/channels/load-from-file', [ChannelController::class, 'loadChannelsFromFile'])->name('channel.loadFromFile');
Route::post('/channels/load-from-file/post', [ChannelController::class, 'loadChannelsFromFilePost'])->name('channel.loadFromFilePost');

Route::get('/video/show/{video_id}', [VideoController::class, 'show'])->name('video.show');
Route::get('/video/new-videos', [VideoController::class, 'newVideos'])->name('video.newVideos');
Route::get('/video/mark-all-watched', [VideoController::class, 'markAllAsWatched'])->name('video.markAllAsWatched');
