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
        Schema::create('level_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('level_id')->nullable();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->foreignId('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('level_users');
    }
};
