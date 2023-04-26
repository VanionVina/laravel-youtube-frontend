<?php

namespace App\Http\Controllers;

use App\Models\Video;
use DateTime;

class VideoController extends Controller
{
    protected $_videos;

    public function __construct() {
        $this->_videos = new Video();
    }

    public function show($video_id) {
        $video = Video::Where('video_id', $video_id)->first();
        if ($video === null) {
            return redirect(route('index'));
        }

        if (!$video->watched) {
            $video->watched = true;
            $video->save();
        }
        
        $invidious_instance = 'https://invidious.snopyta.org';

        return view('videos.show', [
            'video' => $video,
            'invidious_instance' => $invidious_instance,
        ]);
    }

    public function latest() {
        return view('videos.latest', [
            'videos' => $this->_videos->latest(),
        ]);
    }

    public function newVideos() {
        return view('videos.newVideos', [
            'videos' => $this->_videos->unwachedVideos()
        ]);
    }

    public function markAllAsWatched() {
        $this->_videos->markAllAsWatched();
        return redirect(route('video.newVideos'));
    }
}
