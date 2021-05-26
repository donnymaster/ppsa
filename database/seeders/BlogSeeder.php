<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Faker;

class BlogSeeder extends Seeder
{
    const MAX_NB_CHARS = 2000;
    const DEFAULT_PATH_IMG = 'default/article.png';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('uk_UA');

        $titleBlogsDoctor1 = [
            'Топ 5 продуктів для дітей аутистів',
            'Рекомендації по годівлі немовляти аутиста',
            'Правильний раціон на тиждень',
            'Як правильно читати етикетки на продуктах',
            'Топ 10 шкідливих продуктів для дітей-аутистів',
        ];

        $titleBlogsDoctor2 = [
            'Рекомендації по готування картоплі',
            'Популярні раціони за місяць',
            'Топ 10 корисних продуктів для дітей аутистів',
            'Популярні раціони за рік',
            'Чи всі овочі корисні для дітей аутистів',
        ];

        foreach ($titleBlogsDoctor1 as $title) {
            Blog::create([
                'doctor_id' => 1,
                'title' => $title,
                'body' => $faker->text(self::MAX_NB_CHARS),
                'background_path' => self::DEFAULT_PATH_IMG,
                'reading_time' => rand(10, 40),
            ]);
        }

        foreach ($titleBlogsDoctor2 as $title) {
            Blog::create([
                'doctor_id' => 2,
                'title' => $title,
                'body' => $faker->text(self::MAX_NB_CHARS),
                'background_path' => self::DEFAULT_PATH_IMG,
                'reading_time' => rand(10, 40),
            ]);
        }
    }
}
