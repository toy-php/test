<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Category::class, 5)->create()->each(function(\App\Models\Category $category) {
            $products = factory(\App\Models\Product::class, 10)->make()->each(function (\App\Models\Product $product) {
                $file = factory(\App\Models\File::class)->create();
                $product->poster()->associate($file);
            });
            foreach ($products as $product) {
                $category->products()->save($product);
            }
        });
    }
}
