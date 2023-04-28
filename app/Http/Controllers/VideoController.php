<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    protected $_videos;

    public function __construct() {
        $this->_videos = new Video();
    }

    public function show(Video $video) {
        if (!$video->watched) {
            $video->markAsWatched();
        }
        
        $invidious_instance = 'https://invidious.snopyta.org';

        return view('videos.show', [
            'video' => $video,
            'invidious_instance' => $invidious_instance,
        ]);
    }

    public function latest() {
        $videos = $this->_videos->latest();
        return view('videos.latest', compact('videos'));
    }

    public function newVideos() {
        $videos = $this->_videos->unwachedVideos();
        return view('videos.newVideos', compact('videos'));
    }

    public function markAllAsWatched() {
        $this->_videos->markAllAsWatched();
        return redirect()->route('video.newVideos');
    }

    public function markAsWatched(Video $video) {
        $video->markAsWatched();
        return redirect()->route('video.newVideos');
    }
}
