<?php

namespace App\Jobs\Products;

use App\Models\File;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $name;
    protected $description;
    protected $categoryId;
    protected $poster;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param string $name
     * @param string $description
     * @param int $categoryId
     * @param string|null $poster
     */
    public function __construct(int $id, string $name, string $description, int $categoryId, string $poster = null)
    {
        $this->id = $id;
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
        $product = Product::findOrFail($this->id);
        $file = File::wherePath($this->poster)->firstOrNew([]);
        $product->fill([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->categoryId,
            'file_id' => $file->id,
        ])->save();
        return [$product];
    }
}
