<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetRelationRationPartType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ration_parts', function (Blueprint $table) {
            $table->foreign('ration_part_type_id')->references('id')->on('ration_part_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ration_parts', function (Blueprint $table) {
            $table->dropForeign(['ration_part_type_id']);
        });
    }
}
