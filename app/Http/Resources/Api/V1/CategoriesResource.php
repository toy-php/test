<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{

    /**
     * @var Category
     */
    public $resource;

    public function __construct(Category $resource)
    {
        parent::__construct($resource);
    }

}
