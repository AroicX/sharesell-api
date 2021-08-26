<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_id')->nullable();
            $table->string('transcation_id');
            $table->string('reseller_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('product_id')->nullable();
            $table->longText('shipping_payload');
            $table
                ->enum('status', ['pending', 'awaiting', 'done'])
                ->default('pending');

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
        Schema::dropIfExists('shippings');
    }
}
