<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('business_name')->nullable();
            $table->boolean('business_registered')->default(0);
            $table->string('bvn')->nullable();
            $table->longText('current_address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('sms_token', 18)->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table
                ->enum('next_of_kin_relationship', [
                    'brother',
                    'sister',
                    'father',
                    'mother',
                    'uncle',
                    'aunty',
                    'friend',
                ])
                ->nullable();
            $table->string('next_of_kin_email')->nullable();
            $table->char('next_of_kin_gender')->nullable(); // Male or Female
            $table->string('next_of_kin_number')->nullable();
            $table->boolean('sms_verify_status')->default(false);
            $table->dateTime('sms_token_expiry_date')->nullable();
            $table
                ->enum('status', ['active', 'dormant', 'pending', 'blocked'])
                ->default('pending');
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
        Schema::dropIfExists('suppliers');
    }
}
