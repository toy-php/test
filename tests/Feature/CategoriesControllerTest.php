<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase, ApiVersion;

    public function testIndex()
    {
        /** @var Category $category */
        factory(Category::class)->create();

        $categories = Category::with('descendants')->whereNull('parent_id')->get()->toArray();

        $response = $this->get($this->getFullPath('categories'));

        $response->assertStatus(200);

        $response->assertJson([
            'data' => $categories
        ]);
    }

    public function testStore()
    {

        $faker = $this->faker();

        $response = $this->post($this->getFullPath('categories'), [
            'name' => $name = $faker->text(10)
        ]);

        $response->assertStatus(201);

        Category::whereName($name)->firstOrFail();

    }

    public function testShow()
    {

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $response = $this->get($this->getFullPath('categories/' . $category->id));

        $response->assertStatus(200);

        $categories = Category::with('descendants')->where('id', '=', $category->id)->get();

        $response->assertJson([
            'data' => $categories->toArray()
        ]);

    }

    public function testUpdate()
    {
        $faker = $this->faker();

        /** @var Category $category */
        $category = factory(Category::class)->create([
            'name' => $name = $faker->text(10)
        ]);

        $response = $this->put($this->getFullPath('categories/' . $category->id), [
            'name' => $newName = $faker->text(10)
        ]);

        $response->assertStatus(200);

        $this->assertNotEquals($category->name, $response->original->name);

    }

    public function testDestroy()
    {
        $faker = $this->faker();

        /** @var Category $category */
        $category = factory(Category::class)->create([
            'name' => $name = $faker->text(10)
        ]);

        $response = $this->delete($this->getFullPath('categories/' . $category->id));

        $response->assertStatus(200);

        $this->expectException(ModelNotFoundException::class);

        Category::findOrFail($category->id);

    }

}
