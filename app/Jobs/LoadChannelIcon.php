<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LoadChannelIcon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $icon_url;
    protected $icon_name;

    public function __construct($icon_url, $icon_name)
    {
        $this->icon_url = $icon_url;
        $this->icon_name = $icon_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $icon_content = file_get_contents($this->icon_url);
        Storage::disk('public')->put($this->icon_name, $icon_content);
    }
}
