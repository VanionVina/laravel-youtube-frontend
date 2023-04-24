<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    protected $_channel;
    
    public function __construct() {
        $this->_channel = new Channel();
    }

    public function show($channel_id) {
        $channel = Channel::Where('channel_id', $channel_id)->first();

        return view('channels.show', [
            'channel' => $channel,
            'videos' => $channel->videos
        ]);
    }

    public function search(Request $request) {
        $request->validate([
            'search' => 'min:24|max:24'
        ]);

        $channel = $this->_channel->getOrCreateChannelWithVideos($request->search);
        if ($channel === null) {
            return redirect(route('index'))->with('message', 'Incorrect channel id');
        }

        return view('channels.show', [
            'channel' => $channel,
            'videos' => $channel->videos
        ]);
    }
}
