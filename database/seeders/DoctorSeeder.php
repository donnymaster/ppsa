<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Faker;

class DoctorSeeder extends Seeder
{
    const MAX_NB_CHARS = 2000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('uk_UA');

        Doctor::create([
            'user_id' => 1,
            'biography' => $faker->text(self::MAX_NB_CHARS),
            'work_experience' => 5,
            'is_active' => true,
        ]);

        Doctor::create([
            'user_id' => 2,
            'biography' => $faker->text(self::MAX_NB_CHARS),
            'work_experience' => 3,
            'is_active' => true,
        ]);
    }
}
