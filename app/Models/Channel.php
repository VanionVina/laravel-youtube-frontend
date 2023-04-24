<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id', 'name', 'icon_url'
    ];

    public function videos() {
        return $this->hasMany(Video::class);
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
                // dd($entry->content->div->p->__toString());
                Video::create([
                    'channel_id' => $channel->id,
                    'video_id' => substr($entry->id, 9, 11),
                    'title' => $entry->title,
                    'image_url' => $entry->content->div->a->img['src']->__toString(),
                    'description' => $entry->content->div->p->__toString(),
                    'published' => $entry->published,
                ]);
            }
        }

        return $channel;
    }

    public function updateVideos($channel_id) {
        $channel = Channel::where('channel_id', $channel_id)->first();

        $invidious_instance = 'https://invidious.snopyta.org' . '/feed/channel/';
        $feed_url = $invidious_instance . $channel_id;

        $feeds = @simplexml_load_file($feed_url);
        if($feeds === false){
            return null;
        }

        foreach($feeds->entry as $entry) {
            $video = $channel->videos->Where('video_id', substr($entry->id, 9, 11))->first();
            if ($video === null) {
                // TODO 
                // Create notification about new video
                //
                Video::create([
                    'channel_id' => $channel->id,
                    'video_id' => substr($entry->id, 9, 11),
                    'title' => $entry->title,
                    'image_url' => $entry->content->div->a->img['src']->__toString(),
                    'description' => $entry->content->div->p->__toString(),
                    'published' => $entry->published,
                ]);
            }

        }
    }
}
