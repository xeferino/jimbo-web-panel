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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('brand')->nullable();
            $table->string('promoter')->nullable();
            $table->string('place');
            $table->string('provider')->nullable();
            $table->float('cash_to_draw',10,2);
            $table->float('cash_to_collect',10,2);
            $table->enum('type', ['raffle', 'product']);
            $table->date('date_start');
            $table->date('date_end');
            $table->date('date_release');
            $table->integer('days_extend')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('finish')->default(0);
            $table->boolean('public')->default(0);
            $table->string('image')->nullable();
            $table->double('prize_1')->nullable();
            $table->double('prize_2')->nullable();
            $table->double('prize_3')->nullable();
            $table->double('prize_4')->nullable();
            $table->double('prize_5')->nullable();
            $table->double('prize_6')->nullable();
            $table->double('prize_7')->nullable();
            $table->double('prize_8')->nullable();
            $table->double('prize_9')->nullable();
            $table->double('prize_10')->nullable();
            $table->timestamp('draft_at')->nullable();
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
        Schema::dropIfExists('raffles');
    }
};
