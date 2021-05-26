<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductContaining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_containing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_info_id');
            $table->string('name');

            $table->timestampsTz();

            $table->foreign('product_info_id')->references('id')->on('product_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_containing');
    }
}
