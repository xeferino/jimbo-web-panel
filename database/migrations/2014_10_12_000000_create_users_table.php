<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('surnames')->nullable();
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->text('address_city')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('active')->default(1);
            $table->string('image')->nullable()->default('avatar.svg');
            $table->float('balance_usd', 10, 2)->default(0)->nullable();
            $table->float('balance_jib', 10, 2)->default(0)->nullable();
            $table->string('code')->nullable();
            $table->string('code_referral')->nullable();
            $table->integer('type')->nullable();
            $table->integer('become_seller')->default(0)->nullable();
            $table->integer('become_seller_convert')->default(0)->nullable();
            $table->string('token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
};
