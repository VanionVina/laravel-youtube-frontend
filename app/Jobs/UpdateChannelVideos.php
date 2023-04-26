<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateChannelVideos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $channel_id;
    public function __construct($channel_id)
    {
        $this->channel_id = $channel_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $_channel = new Channel();
        $_channel->updateVideos($this->channel_id);
    }
}
