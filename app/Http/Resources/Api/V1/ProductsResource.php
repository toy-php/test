<?php

namespace App\Http\Resources\Api\V1;

use App\Http\Resources\FilesResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{

    /**
     * @var Product
     */
    public $resource;

    public function __construct(Product $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'poster' => $this->resource->file_id ? new FilesResource($this->resource->poster) : null
        ];
    }
}
