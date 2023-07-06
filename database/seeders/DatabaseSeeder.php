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

        // Временно
        \App\Models\User::factory()->create([
            'name' => 'test1',
            'phone' => '+7 (900) 123-45-67',
            'email' => 'test1@test.com',
            'password' => 'test1'
        ]);

        // Постоянно
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
            ['name' => 'Модели памятников'],
            ['name' => 'Вертикальные', 'parent_id' => 1],
            ['name' => 'Горизонтальные', 'parent_id' => 1],
            ['name' => 'Материал'],
        ];
        foreach($categoryList as $category) {
            $translit = \App\Helpers\translit($category['name']);
            \App\Models\Category::factory()->create([
                'name' => $category['name'],
                'translit' => $translit,
                //'parent_id' => (int)$category['parent_id'],
            ]);
            Storage::makeDirectory("/public/images/".$translit);
        }
        /*
        Модели 1
        - Вертикальные 2
        - Горизонтальные 3

        Материал 4
        - Гранит 5
        - Мрамор 6

        Портрет 7
        - Гравировка 8
        - Фотокерамика 9

        Размер стеллы 10
        - Вертикальные 11
        - Горизонтальные 12

        Гравировка 13
        - Кресты 14
        - Цветы 15
        - Ветви 16
        - Свечи 17
        - Ангелы 18
        - Птицы 19

        Надгробие 20
        */

    }
}
