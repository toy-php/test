<?php

namespace App\Jobs\Files;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function handle()
    {
        $path = File::getDisk()
            ->put(File::getDirectory(), $this->file);
        $file = File::create([
            'path' => $path
        ]);
        return [$file];
    }
}
