<?php

namespace App\Jobs\Categories;

use App\Models\Category;
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
    protected $parentId;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param string $name
     * @param int|null $parentId
     */
    public function __construct(int $id, string $name, int $parentId = null)
    {
        $this->id = $id;
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
        $category = Category::findOrFail($this->id);
        $category->name = $this->name;
        if (!empty($this->parentId)) {
            $parent = Category::findOrFail($this->parentId);
            $category->parent()->associate($parent)->save();
        }
        return [$category];
    }
}
