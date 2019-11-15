<?php

namespace App\Jobs\Files;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DestroyCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     * @throws \Exception
     */
    public function handle()
    {
        $file = File::wherePath($this->path)->firstOrFail();
        $disk = File::getDisk();
        if ($disk->exists($file->path)) {
            $disk->delete($file->path);
        }
        return $file->delete();
    }
}
