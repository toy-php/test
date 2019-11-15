<?php

namespace App\Jobs\Products;

use App\Models\File;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $description;
    protected $categoryId;
    protected $poster;

    /**
     * Create a new job instance.
     *
     * @param string $name
     * @param string $description
     * @param int $categoryId
     * @param string|null $poster
     */
    public function __construct(string $name, string $description, int $categoryId, string $poster = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->poster = $poster;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $file = File::wherePath($this->poster)->firstOrNew([]);
        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'file_id' => $file->id,
        ]);
        return [$product];
    }
}
