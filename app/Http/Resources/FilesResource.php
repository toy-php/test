<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class FilesResource extends JsonResource
{

    /**
     * @var File
     */
    public $resource;

    public function __construct(File $resource)
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
            'path' => $this->resource->path
        ];
    }
}
