<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('currency_id');
            $table->double('block_reward', 8, 4, true);
            $table->float('difficulty_level');
            $table->integer('memory_conversion');
            $table->integer('exchange_rate');
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
        Schema::dropIfExists('mines');
    }
}
