<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');
            $table->uuid('primary_role')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table
                ->string('email')
                ->unique()
                ->nullable();
            $table->char('gender', 1)->nullable(); //M-Male, F-> Female
            $table->string('one_time_password')->nullable();
            $table->boolean('email_verified')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('last_login')->nullable();
            $table->longText('last_ip_used')->nullable();
            $table
                ->enum('registration_steps', [
                    'check-phone',
                    'verify-otp',
                    'quick-registration',
                    'step-4',
                ])
                ->default('check-phone');
            $table
                ->enum('status', ['active', 'dormant', 'pending', 'blocked'])
                ->default('pending');
            $table
                ->foreign('primary_role')
                ->references('role_id')
                ->on('roles')
                ->onDelete('cascade');
            $table->unique('user_id');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
