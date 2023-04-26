<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoNotification extends Model
{
    use HasFactory;

    public function video() {
        return $this->belongsTo(Video::class);
    }

    protected $fillable = [
        'video_id'
    ];

    public function countNew() {
        return $this->count();
    }
}
