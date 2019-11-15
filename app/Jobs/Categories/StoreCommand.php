<?php

namespace App\Jobs\Categories;

use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $parentId;

    /**
     * Create a new job instance.
     *
     * @param string $name
     * @param int|null $parentId
     */
    public function __construct(string $name, int $parentId = null)
    {
        $this->name = $name;
        $this->parentId = $parentId;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        /** @var Category $category */
        $category = Category::create([
            'name' => $this->name
        ]);
        if (!empty($this->parentId)) {
            $parent = Category::findOrFail($this->parentId);
            $category->appendToNode($parent);
        }
        return [$category];
    }

}
