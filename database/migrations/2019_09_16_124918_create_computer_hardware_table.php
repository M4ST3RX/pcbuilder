<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputerHardwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computer_hardware', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hardware_type_id');
            $table->unsignedBigInteger('price');
            $table->string('name');
            $table->longText('data');
            $table->timestamps();

            $table->foreign('hardware_type_id')->references('id')->on('hardware_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computer_hardware');
    }
}
