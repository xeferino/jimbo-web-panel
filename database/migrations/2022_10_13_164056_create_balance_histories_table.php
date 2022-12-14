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
        Schema::create('balance_histories', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->enum('type',['debit', 'credit'])->nullable();
            $table->string('operation', 45)->nullable();
            $table->string('currency')->nullable();
            $table->float('balance',10,2)->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('balance_histories');
        Schema::table('balance_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
