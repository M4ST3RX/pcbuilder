<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnsToComputerHardwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computer_hardware', function (Blueprint $table) {
            $table->string('type')->after('name');
            $table->unsignedBigInteger('brand')->after('type');
            $table->boolean('listed')->default(true)->after('brand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computer_hardware', function (Blueprint $table) {
            $table->dropColumn(['type', 'brand', 'listed']);
        });
    }
}
