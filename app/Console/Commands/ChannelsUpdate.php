<?php

namespace App\Console\Commands;

use App\Models\Channel;
use Illuminate\Console\Command;

class ChannelsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:channels-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update channel videos every X minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $_channel = new Channel();
        $channels = Channel::get();
        foreach($channels as $channel) {
            $_channel->updateVideos($channel->channel_id);
        }
        $this->info("Task channels-update completed");
    }
}
