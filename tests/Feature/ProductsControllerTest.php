<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase, ApiVersion;

    public function testIndex()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $category->each(function (Category $category) {
            $products = factory(Product::class, 3)->make();
            foreach ($products as $product) {
                $category->products()->save($product);
            }
        });

        $response = $this->get($this->getFullPath('products'));

        $response->assertStatus(200);

        $category->refresh();

        $response->assertJson([
            'data' => $category->products->makeHidden([
                'category_id',
                'file_id',
                'deleted_at'
            ])->toArray()
        ]);

    }

    public function testStore()
    {
        $faker = $this->faker();

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $response = $this->postJson($this->getFullPath('products'), [
            'name' => $name = $faker->text(10),
            'description' => $faker->text(100),
            'category_id' => $category->id
        ]);

        $response->assertStatus(201);

        Product::whereName($name)->firstOrFail();
    }

    public function testShow()
    {
        $faker = $this->faker();
        /** @var Category $category */
        $category = factory(Category::class)->create();

        /** @var Product $product */
        $product = $category->products()->create([
            'name' => $faker->text(10),
            'description' => $faker->text(100)
        ]);

        $response = $this->get($this->getFullPath('products/' . $product->id));

        $response->assertStatus(200);

        $response->assertJson([
            'data' => $product->makeHidden([
                'category_id',
                'file_id',
                'deleted_at'
            ])->toArray()
        ]);

    }

    public function testUpdate()
    {
        $faker = $this->faker();
        /** @var Category $category */
        $category = factory(Category::class)->create();

        /** @var Product $product */
        $product = $category->products()->create([
            'name' => $faker->text(10),
            'description' => $faker->text(100)
        ]);

        $response = $this->putJson($this->getFullPath('products/' . $product->id), [
            'name' => $faker->text(10),
            'description' => $faker->text(100),
            'category_id' => $category->id
        ]);

        $response->assertStatus(200);

        $this->assertNotEquals($product->name, $response->original->name);
        $this->assertNotEquals($product->description, $response->original->description);

    }

    public function testDestroy()
    {
        $faker = $this->faker();
        /** @var Category $category */
        $category = factory(Category::class)->create();

        /** @var Product $product */
        $product = $category->products()->create([
            'name' => $faker->text(10),
            'description' => $faker->text(100)
        ]);

        $this->delete($this->getFullPath('products/' . $product->id));

        $this->expectException(ModelNotFoundException::class);

        Product::findOrFail($product->id);

    }

}
