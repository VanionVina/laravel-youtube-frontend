<?php

namespace App\Models;

use App\Jobs\UpdateChannelVideos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $_video;

    public function __construct() {
        $this->_video = new Video();
    }

    protected $fillable = [
        'channel_id', 'name', 'icon_url'
    ];

    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function getOrCreateChannel($channel_id) {
        $channel = Channel::where('channel_id', $channel_id)->first();
        if ($channel === null) {

        }
    }
    public function getOrCreateChannelWithVideos($channel_id) {
        $channel = Channel::where('channel_id', $channel_id)->first();
        if($channel === null) {
            $invidious_instance = 'https://invidious.snopyta.org' . '/feed/channel/';
            $feed_url = $invidious_instance . $channel_id;

            $feeds = @simplexml_load_file($feed_url);
            if($feeds === false){
                return null;
            }
            $channel = Channel::create([
                'channel_id' => $channel_id,
                'name' => $feeds->title,
                'icon_url' => $feeds->icon,
            ]);

            foreach($feeds->entry as $entry) {
                $this->_video->createVideo($entry, $channel->id);
            }
        }

        return $channel;
    }

    public function updateVideos($channel_id) {
        // channel can't be null here
        $channel = Channel::where('channel_id', $channel_id)->first();

        $invidious_instance = 'https://invidious.snopyta.org' . '/feed/channel/';
        $feed_url = $invidious_instance . $channel_id;

        $feeds = @simplexml_load_file($feed_url);

        $new_videos_available = false;

        foreach($feeds->entry as $entry) {
            $video = $channel->videos->Where('video_id', substr($entry->id, 9, 11))->first();
            if ($video === null) {
                $this->_video->createVideo($entry, $channel->id);
                $new_videos_available = true;
            }
        }

        return $new_videos_available;
    }

    public function updateAllChannelsVideos() {
        $channels = Channel::get('channel_id');
        foreach($channels as $channel) {
            UpdateChannelVideos::dispatch($channel->channel_id);
        }
    }
}
