<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


/** Работа с файлами */
Route::post('files', 'FilesController@store')->name('files.store');
Route::get('files/{path}', 'FilesController@show')->where('path', '.*')->name('files.show');
Route::delete('files/{path}', 'FilesController@destroy')->where('path', '.*')->name('files.destroy');
