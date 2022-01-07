<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('user_id')->nullable();
            $table->string('quote_id')->nullable();
            $table->string('reseller_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('product_id')->nullable();
            $table->longText('customer_details')->nullable();
            $table->longText('payment_payload');
            $table
                ->enum('status', ['pending', 'awaiting', 'completed'])
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
        Schema::dropIfExists('transactions');
    }
}
