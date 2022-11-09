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
        Schema::create('cash_requests', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable()->default('usd');
            $table->float('amount',10,2)->nullable();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->enum('status',['approved', 'refused', 'pending', 'return', 'created']);
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('account_user_id')->nullable();
            $table->foreign('account_user_id')->references('id')->on('account_users')->onDelete('cascade');
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
        Schema::dropIfExists('cash_requests');
    }
};
