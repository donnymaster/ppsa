<?php

namespace Database\Factories;

use App\Models\Ration;
use Illuminate\Database\Eloquent\Factories\Factory;

class RationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ration::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Title racion 1',
            'is_doctor_create' => false,
            'start' => now()->setTime(0, 0),
            'end' => now()->addDays(1)->setTime(0, 0),
        ];
    }
}
