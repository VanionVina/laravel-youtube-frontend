<?php

namespace App\Http\Controllers;

use App\Jobs\AddChannel;
use App\Jobs\LoadChannelIcon;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChannelController extends Controller
{
    protected $_channel;
    protected $invidious_instance;
    
    public function __construct() {
        $this->_channel = new Channel();
        $this->invidious_instance = 'https://invidious.snopyta.org';
    }

    public function index() {
        $channels = Channel::orderBy('name')->get();
        return view('channels.index', [
            'channels' => $channels,
        ]);
    }

    public function show($channel_id) {
        $channel = Channel::Where('channel_id', $channel_id)->first();
        if ($channel === null) {
            return redirect(route('index'));
        }

        return view('channels.show', [
            'channel' => $channel,
            'videos' => $channel->videos,
            'invidious_link' => $this->invidious_instance . '/channel/' . $channel->channel_id,
        ]);
    }

    public function updateVideos($channel_id) {
        $channel = Channel::Where('channel_id', $channel_id)->first();
        if ($channel === null) {
            return redirect(route('index'));
        }

        if($this->_channel->updateVideos($channel_id))
        {
            return redirect(route('channel.show', $channel_id))->with('channelMessage', 'Images are loading. Please refresh the page to see them');
        }
        return redirect(route('channel.show', $channel_id))->with('channelMessage', 'No new videos');
    }

    public function updateAll() {
        $this->_channel->updateAllChannelsVideos();
        return redirect(route('video.newVideos'))->with('videoMessage', 'Loading RSS feeds... Check this page later');
    }

    public function search(Request $request) {
        $request->validate([
            'search' => 'min:24|max:24'
        ]);

        $channel = $this->_channel->getOrCreateChannelWithVideos($request->search);
        if ($channel === null) {
            return redirect(route('index'))->with('errorMessage', 'Incorrect channel id');
        }

        return redirect(route('channel.show', $channel->channel_id))->with('channelMessage', 'Images are loading. Please refresh the page to see them');
    }

    public function loadChannelsFromFile() {
        return view('channels.loadChannelsFromFile');
    }

    public function loadChannelsFromFilePost(Request $request) {
        $request->validate([
            'file' => 'mimes:csv|required'
        ]);

        $file_handle = fopen($request->file, 'r');
        while (!feof($file_handle)) {
            $csv_file[] = fgetcsv($file_handle, 0, ',');
        }
        fclose($file_handle);

        for ($i=1; $i<count($csv_file)-1;$i++) {
            AddChannel::dispatch($csv_file[$i][0]);
        }

        return redirect(route('channel.index'))->with('channelMessage', 'Loading channels... Refresh the page to see them.');
    }
}
