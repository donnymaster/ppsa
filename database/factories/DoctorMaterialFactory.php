<?php

namespace Database\Factories;

use App\Models\DoctorMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorMaterialFactory extends Factory
{
    const NAME_FILE = 'accreditation document';
    const PATH_FILE = 'default/article.png';

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => self::NAME_FILE,
            'material_path' => self::PATH_FILE,
        ];
    }
}
