<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('Название товара');
            $table->text('description')->comment('Описание товара');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['file_id']);
        });
        Schema::dropIfExists('products');
    }
}
