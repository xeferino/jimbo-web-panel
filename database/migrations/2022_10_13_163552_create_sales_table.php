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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('dni')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->float('amount',10,2)->nullable();
            $table->string('number')->nullable();
            $table->string('number_culqi')->nullable();
            $table->integer('quantity')->nullable();
            $table->foreignId('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('set null');
            $table->foreignId('seller_id')->nullable();
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignId('raffle_id')->nullable();
            $table->foreign('raffle_id')->references('id')->on('raffles')->onDelete('set null');
            $table->enum('status',['approved', 'refused', 'pending']);
            $table->enum('method',['jib', 'card', 'cash', 'other']);
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
        Schema::dropIfExists('sales');
    }
};
