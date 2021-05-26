<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class DoctorFactory extends Factory
{
    const MAX_NB_CHARS = 2000;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create('uk_UA');

        return [
            'biography' => $faker->text(self::MAX_NB_CHARS),
            'work_experience' => rand(1, 5),
            'is_active' => true,
        ];
    }
}
