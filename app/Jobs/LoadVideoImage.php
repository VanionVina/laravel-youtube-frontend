<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LoadVideoImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $image_url;
    protected $image_name;

    public function __construct($image_url, $image_name)
    {
        $this->image_url = $image_url;
        $this->image_name = $image_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image_content = file_get_contents($this->image_url);
        Storage::disk('public')->put($this->image_name, $image_content);
    }
}
