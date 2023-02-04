<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('crypto_wallet_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->unsignedBigInteger('level')->default(1);
            $table->dateTime('mine_start_time')->nullable();
            $table->unsignedBigInteger('mine_id')->nullable();
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
        Schema::dropIfExists('computers');
    }
}
