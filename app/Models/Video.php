<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id', 'video_id', 'title', 'image_url', 'description', 'published'
    ];

    public function channel() {
        return $this->belongsTo(Channel::class);
    }
}
