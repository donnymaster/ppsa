<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class BlogFactory extends Factory
{
    const MAX_NB_CHARS = 2000;
    const DEFAULT_PATH_IMG = 'default/article.png';

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker\Factory::create('uk_UA');

        return [
            'title' => $faker->text(100),
            'body' => $faker->text(self::MAX_NB_CHARS),
            'background_path' => self::DEFAULT_PATH_IMG,
            'reading_time' => rand(10, 40),
        ];
    }
}
