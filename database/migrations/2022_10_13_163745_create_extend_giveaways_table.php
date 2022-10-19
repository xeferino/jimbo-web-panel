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
        Schema::create('extend_giveaways', function (Blueprint $table) {
            $table->id();
            $table->date('date_back');
            $table->integer('days');
            $table->date('date_next');
            $table->foreignId('raffle_id');
            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('cascade');
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('extend_giveaways');
        Schema::table('extend_giveaways', function (Blueprint $table) {
            $table->dropForeign(['raffle_id']);
            $table->dropColumn('raffle_id');
        });
    }
};
