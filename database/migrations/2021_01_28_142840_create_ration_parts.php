<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRationParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ration_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ration_part_type_id');
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ration_id');

            $table->timestampsTz();

            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ration_id')->references('id')->on('rations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ration_parts');
    }
}
