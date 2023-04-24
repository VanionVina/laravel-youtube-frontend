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

Route::get('/', [FrontpageController::class, 'index'])->name('index');

Route::get('/channel/show/{channel_id}', [ChannelController::class, 'show'])->name('channel.show');
Route::post('/channel/search', [ChannelController::class, 'search'])->name('channel.search');

Route::get('/video/{video_id}', [VideoController::class, 'show'])->name('video.show');
