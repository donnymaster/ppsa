<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Заготовки',
            'Випічка та десерти',
            'Основні страви',
            'Сніданки',
            'Салати',
            'Супи',
            'Паста і піца',
            'Закуски',
            'Сендвічі',
            'Різотто',
            'Напої',
            'Соуси і маринади',
            'Бульйони',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
