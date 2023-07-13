<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Тестовый пользователь
        \App\Models\User::factory()->create([
            'name' => 'test1',
            'phone' => '+7 (900) 123-45-67',
            'email' => 'test1@test.com',
            'password' => 'test1'
        ]);

        // Статусы
        $statusList = [
            1 => 'Принят',
            2 => 'Выполняется',
            3 => 'Готов',
            4 => 'Отказ',
            5 => 'Остановлен',
        ];
        foreach($statusList as $status) {
            \App\Models\Status::factory()->create(['name' => $status]);
        }

        // Категории
        $categoryList = [

            ['name' => 'Модели памятников', 'parent_id' => null],
            ['name' => 'Вертикальные', 'parent_id' => 1],
            ['name' => 'Горизонтальные', 'parent_id' => 1],

            ['name' => 'Материал', 'parent_id' => null],
            ['name' => 'Гранит', 'parent_id' => 4],
            ['name' => 'Мрамор', 'parent_id' => 4],

            ['name' => 'Портрет', 'parent_id' => null],
            ['name' => 'Гравировка', 'parent_id' => 7],
            ['name' => 'Фотокерамика', 'parent_id' => 7],

            ['name' => 'Дополнительная гравировка', 'parent_id' => null],
            ['name' => 'Кресты', 'parent_id' => 10],
            ['name' => 'Цветы', 'parent_id' => 10],
            ['name' => 'Ветви', 'parent_id' => 10],
            ['name' => 'Свечи', 'parent_id' => 10],
            ['name' => 'Ангелы', 'parent_id' => 10],
            ['name' => 'Птицы', 'parent_id' => 10],

            ['name' => 'Цветник / надгробие', 'parent_id' => null],

            ['name' => 'Ограды', 'parent_id' => null],

            ['name' => 'Вазы', 'parent_id' => null],
            ['name' => 'Литьевые и мрамор', 'parent_id' => 19],
            ['name' => 'Гранитные', 'parent_id' => 19],
            ['name' => 'Лампады', 'parent_id' => 19],

            ['name' => 'Облицовка', 'parent_id' => null], // ID:23

        ];
        foreach($categoryList as $category) {
            \App\Models\Category::factory()->create([
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
            ]);
        }

        // Товары
        $productList = [
            [''],
        ];

        // Размеры стеллы
        $sizeList = [
            ['width' => 80, 'height' => 40, 'thick' => 5, 'category_id' => 2],
            ['width' => 100, 'height' => 50, 'thick' => 5, 'category_id' => 2],
            ['width' => 120, 'height' => 60, 'thick' => 5, 'category_id' => 2],
            ['width' => 80, 'height' => 40, 'thick' => 8, 'category_id' => 2],
            ['width' => 100, 'height' => 50, 'thick' => 8, 'category_id' => 2],
            ['width' => 120, 'height' => 60, 'thick' => 8, 'category_id' => 2],
            ['width' => 140, 'height' => 70, 'thick' => 8, 'category_id' => 2],
            ['width' => 80, 'height' => 40, 'thick' => 10, 'category_id' => 2],
            ['width' => 100, 'height' => 40, 'thick' => 10, 'category_id' => 2],
            ['width' => 120, 'height' => 40, 'thick' => 10, 'category_id' => 2],
            ['width' => 140, 'height' => 40, 'thick' => 10, 'category_id' => 2],
            ['width' => 160, 'height' => 40, 'thick' => 10, 'category_id' => 2],
            ['width' => 100, 'height' => 50, 'thick' => 12, 'category_id' => 2],
            ['width' => 120, 'height' => 60, 'thick' => 12, 'category_id' => 2],
            ['width' => 140, 'height' => 70, 'thick' => 12, 'category_id' => 2],
            ['width' => 160, 'height' => 80, 'thick' => 12, 'category_id' => 2],

            ['width' => 60, 'height' => 80, 'thick' => 5, 'category_id' => 3],
            ['width' => 70, 'height' => 100, 'thick' => 5, 'category_id' => 3],
            ['width' => 80, 'height' => 120, 'thick' => 5, 'category_id' => 3],
            ['width' => 60, 'height' => 80, 'thick' => 8, 'category_id' => 3],
            ['width' => 70, 'height' => 100, 'thick' => 8, 'category_id' => 3],
            ['width' => 80, 'height' => 120, 'thick' => 8, 'category_id' => 3],
            ['width' => 100, 'height' => 140, 'thick' => 8, 'category_id' => 3],
            ['width' => 60, 'height' => 80, 'thick' => 10, 'category_id' => 3],
            ['width' => 70, 'height' => 100, 'thick' => 10, 'category_id' => 3],
            ['width' => 80, 'height' => 120, 'thick' => 10, 'category_id' => 3],
            ['width' => 100, 'height' => 140, 'thick' => 10, 'category_id' => 3],
            ['width' => 120, 'height' => 160, 'thick' => 10, 'category_id' => 3],
            ['width' => 70, 'height' => 100, 'thick' => 12, 'category_id' => 3],
            ['width' => 80, 'height' => 120, 'thick' => 12, 'category_id' => 3],
            ['width' => 100, 'height' => 140, 'thick' => 12, 'category_id' => 3],
            ['width' => 120, 'height' => 160, 'thick' => 12, 'category_id' => 3],
        ];
        foreach($sizeList as $size) {
            \App\Models\Size::factory()->create([
                'width' => $size['width'],
                'height' => $size['height'],
                'thick' => $size['thick'],
                'category_id' => $size['category_id'],
            ]);
        }

    }
}
