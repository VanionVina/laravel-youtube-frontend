<?php

namespace App\Models;

use App\Jobs\LoadChannelIcon;
use App\Jobs\UpdateChannelVideos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $_video;
    protected $invidious_instance;

    public function __construct() {
        $this->_video = new Video();
        $this->invidious_instance = 'https://invidious.snopyta.org' . '/feed/channel/';
    }

    protected $fillable = [
        'channel_id', 'name', 'icon_url', 'icon_name'
    ];

    public function videos() {
        return $this->hasMany(Video::class)->orderBy('published', 'desc');
    }

    public function getOrCreateChannelWithVideos($channel_id) {
        $channel = Channel::where('channel_id', $channel_id)->first();
        if($channel === null) {
            $feed_url = $this->invidious_instance . $channel_id;

            $feeds = @simplexml_load_file($feed_url);
            if($feeds === false){
                return null;
            }

            $icon_url = $feeds->icon->__toString();
            $icon_name = 'channel_' . $channel_id . '.jpg';

            LoadChannelIcon::dispatch($icon_url, $icon_name);
            $channel = Channel::create([
                'channel_id' => $channel_id,
                'name' => $feeds->title,
                'icon_url' => $icon_url,
                'icon_name' => $icon_name
            ]);


            foreach($feeds->entry as $entry) {
                $this->_video->createVideo($entry, $channel->id);
            }
        }

        return $channel;
    }

    public function updateVideos() {
        $invidious_instance = 'https://invidious.snopyta.org' . '/feed/channel/';
        $feed_url = $invidious_instance . $this->channel_id;

        $feeds = @simplexml_load_file($feed_url);

        $new_videos_available = false;

        foreach($feeds->entry as $entry) {
            $video = $this->videos->Where('video_id', substr($entry->id, 9, 11))->first();
            if ($video === null) {
                $this->_video->createVideo($entry, $this->id);
                $new_videos_available = true;
            }
        }

        return $new_videos_available;
    }

    public function updateAllChannelsVideos() {
        $channels = Channel::get();
        foreach($channels as $channel) {
            UpdateChannelVideos::dispatch($channel);
        }
    }
}
