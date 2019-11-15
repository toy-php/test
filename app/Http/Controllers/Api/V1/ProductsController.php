<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\StoreRequest;
use App\Http\Requests\Api\V1\Products\UpdateRequest;
use App\Http\Resources\Api\V1\ProductsResource;
use App\Jobs\Products\DestroyCommand;
use App\Jobs\Products\StoreCommand;
use App\Jobs\Products\UpdateCommand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $products = Product::filterCategory($request->category)->get();
        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return ProductsResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        [$product] = dispatch_now(new StoreCommand($data['name'], $data['description'], $data['category_id'], $data['poster'] ?? null));
        return new ProductsResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ProductsResource
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductsResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return ProductsResource
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        [$product] = dispatch_now(new UpdateCommand($id, $data['name'], $data['description'], $data['category_id'], $data['poster'] ?? null));
        return new ProductsResource($product);
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
