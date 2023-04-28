<?php

namespace App\Models;

use App\Jobs\LoadVideoImage;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id', 'video_id', 'title', 'image_name',
        'image_path', 'description', 'published'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function latest() {
        return $this->orderBy('published', 'desc')->paginate(40);
    }

    public function unwachedVideos() {
        return $this->where('watched', '=', false)->orderBy('published', 'desc')->paginate(40);
    }

    public function createVideo($entry, $channel_id) {
            $image_url = $entry->content->div->a->img['src']->__toString();
            $image_name = substr($entry->id, 9, 11).'.jpg';

            LoadVideoImage::dispatch($image_url, $image_name);

            $video = Video::create([
                'channel_id' => $channel_id,
                'video_id' => substr($entry->id, 9, 11),
                'title' => $entry->title,
                'image_name' => $image_name,
                'image_path' => public_path('') . $image_name,
                'description' => $entry->content->div->p->__toString(),
                'published' => $entry->published,
            ]);

            return $video;
    }

    public function markAsWatched() {
        $this->watched = true;
        $this->save();
    }

    public function markAllAsWatched() {
        Video::where('watched', false)->update(['watched' => true]);
    }

    // Should change this to diffForHumans()
    public function getDateDifference() {
        $parsed_date = DateTime::createFromFormat('Y-m-d H:i:s', str_replace('T', ' ', substr($this->published, 0, 19)));
        $current_date = date_create(date('m/d/Y h:i:s a', time()));
        $date_diff = date_diff($parsed_date, $current_date);

        if ($date_diff->days < 1) {
            return $date_diff->format('%h hours ago');
        } elseif ($date_diff->days == 1) {
            return $date_diff->format('%a day ago');
        }

        return $date_diff->format('%a days ago');
    }
}
