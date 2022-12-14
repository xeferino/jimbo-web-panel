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
        Schema::create('card_users', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
            $table->string('culqi_card_id')->nullable();
            $table->string('culqi_token_id')->nullable();
            $table->string('culqi_customer_id')->nullable();
            $table->boolean('default')->default(1);
            $table->string('icon')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('card_users');
        Schema::table('card_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
