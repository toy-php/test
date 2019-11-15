<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Requests\Api\V1\Categories\UpdateRequest;
use App\Http\Resources\Api\V1\CategoriesResource;
use App\Jobs\Categories\DestroyCommand;
use App\Jobs\Categories\StoreCommand;
use App\Jobs\Categories\UpdateCommand;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $categories = Category::with('descendants')->whereNull('parent_id')->get();
        return  CategoriesResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return CategoriesResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        [$category] = dispatch_now(new StoreCommand($data['name'], $data['parent_id'] ?? null));
        return  new CategoriesResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function show($id)
    {
        $categories = Category::with('descendants')->where('id', '=', $id)->get();
        return  CategoriesResource::collection($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return CategoriesResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        [$category] = dispatch_now(new UpdateCommand($id, $data['name'], $data['parent_id'] ?? null));
        return  new CategoriesResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy($id)
    {
        $result = dispatch_now(new DestroyCommand($id));
        return [
            'result' => $result
        ];
    }
}
