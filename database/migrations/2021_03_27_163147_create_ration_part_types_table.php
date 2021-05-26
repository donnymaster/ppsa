<?php

use App\Models\RationPartType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRationPartTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ration_part_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('key', 255);
            $table->string('range', 255);

            $table->timestampsTz();
        });

        $types = [
            [
                'name' => 'Сніданок',
                'key' => 'lunch',
                'range' => 'з 6 до 9 годин ранку',
            ],
            [
                'name' => 'Обід',
                'key' => 'dinner',
                'range' => 'з 12 до 13 годин дня',
            ],
            [
                'name' => 'Полудень',
                'key' => 'nooning',
                'range' => 'з 16 до 17 годин дня',
            ],
            [
                'name' => 'Вечеря',
                'key' => 'supper',
                'range' => 'з 18 до 20 години вечора',
            ],
        ];

        foreach ($types as $val) {
            RationPartType::create([
                'name' => $val['name'],
                'key' => $val['key'],
                'range' => $val['range'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ration_part_types');
    }
}
