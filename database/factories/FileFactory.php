<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    $relPath =  File::getDirectory();
    $directory = storage_path('app/public/' . $relPath);
    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }
    $fullPath = $faker->image($directory);
    return [
        'path' => $relPath . '/' . basename($fullPath)
    ];
});
