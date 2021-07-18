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
            $table->id();
            $table->uuid('user_id')->unsigned();
            $table->uuid('product_category');
            $table->string('product_name');
            $table->longText('product_images');
            $table->longText('product_description');
            $table->integer('product_price');
            $table->integer('product_weight');
            $table->integer('product_size');
            $table->integer('product_quantity');
            $table->integer('product_number');
            $table->integer('product_retail_price');
            $table->longText('pickup_addreess');
            $table->string('state');
            $table->string('city');
            $table
                ->enum('status', ['available', 'unavailable', 'out-of-stock'])
                ->default('available');
            $table
                ->foreign('product_category')
                ->references('category_id')
                ->on('product_categories')
                ->onDelete('cascade');
            $table->unique('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
