<?php

use Illuminate\Http\Request;

Route::middleware('api')->group(function () {

    Route::resource('categories', 'CategoriesController')->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('products', 'ProductsController')->only(['index', 'show', 'store', 'update', 'destroy']);
});


