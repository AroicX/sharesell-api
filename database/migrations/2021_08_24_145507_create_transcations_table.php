<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcations', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('reseller_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('transcation_id');
            $table->longText('payment_payload');
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
        Schema::dropIfExists('transcations');
    }
}
