<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channel\SearchRequest;
use App\Jobs\AddChannel;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    protected $_channel;
    protected $invidious_instance;
    protected $images_loading_message;
    
    public function __construct() {
        $this->_channel = new Channel();
        $this->invidious_instance = 'https://invidious.snopyta.org';
        $this->images_loading_message = 'Images are loading. Please refresh the page to see them';
    }

    public function index() {
        $channels = Channel::orderBy('name')->get();
        return view('channels.index', compact('channels'));
    }

    public function show(Channel $channel) {
        return view('channels.show', [
            'channel' => $channel,
            'videos' => $channel->videos,
            'invidious_link' => $this->invidious_instance . '/channel/' . $channel->channel_id,
        ]);
    }

    public function updateVideos(Channel $channel) {
        if($channel->updateVideos())
        {
            return redirect(route('channel.show', $channel))->with('channelMessage', $this->images_loading_message);
        }
        return redirect(route('channel.show', $channel->id))->with('channelMessage', 'No new videos');
    }

    public function updateAll() {
        $this->_channel->updateAllChannelsVideos();
        return redirect(route('video.newVideos'))->with('videoMessage', 'Loading RSS feeds... Check this page later');
    }

    public function search(SearchRequest $request) {
        $channel_id = $request->validated()['search'];

        $channel = $this->_channel->getOrCreateChannelWithVideos($channel_id);
        if ($channel === null) {
            return redirect(route('index'))->with('errorMessage', 'Incorrect channel id');
        }
        return redirect(route('channel.show', $channel->id))->with('channelMessage', $this->images_loading_message);
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
