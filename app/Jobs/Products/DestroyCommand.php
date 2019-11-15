<?php

namespace App\Jobs\Products;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DestroyCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return boolean
     * @throws \Exception
     */
    public function handle()
    {
        $product = Product::findOrFail($this->id);
        if (!empty($product->file_id)) {
            dispatch_now(new \App\Jobs\Files\DestroyCommand($product->poster->path));
        }
        return $product->delete();
    }
}
