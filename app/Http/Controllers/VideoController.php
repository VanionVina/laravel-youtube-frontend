<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($video_id) {
        $video = Video::Where('video_id', $video_id)->first();
        $invidious_instance = 'https://invidious.snopyta.org';
        $youtube_url = 'https://www.youtube.com/watch?v=' . $video->video_id;

        return view('videos.show', [
            'video' => $video,
            'invidious_instance' => $invidious_instance,
            'youtube_url' => $youtube_url
        ]);
    }
}
