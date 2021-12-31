<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qoutes', function (Blueprint $table) {
            $table->id();
            $table->string('qoute_id');
            $table->string('reseller_id');
            $table->string('supplier_id');
            $table->string('product_id');
            $table->string('origin_state')->nullable();
            $table->string('origin_city')->nullable();
            $table->string('destination_state');
            $table->string('destination_city');
            $table->integer('delivery_fee');
            $table->longText('rate_key');
            $table->longText('payload')->nullable();
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
        Schema::dropIfExists('qoutes');
    }
}
