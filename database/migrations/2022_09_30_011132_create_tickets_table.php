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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('serial');
            $table->foreignId('promotion_id');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->foreignId('raffle_id');
            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['raffle_id', 'promotion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->dropColumn('promotion_id');
            $table->dropForeign(['raffle_id']);
            $table->dropColumn('raffle_id');
        });
    }
};
