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

        // Группа доступа пользователя
        $userGroup = [
            1 => 'Администратор',
            2 => 'Модератор',
            3 => 'Пользователь',
        ];
        foreach($userGroup as $group) {
            \App\Models\UserGroup::factory()->create(['name' => $group]);
        }

        // Пользователи
        \App\Models\User::factory()->create([
            'name' => 'Haidar',
            'phone' => '+7 (000) 111-11-11',
            'email' => 'haidar@haidar.ru',
            'password' => 'guS93!sQ',
            'user_group' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Anton',
            'phone' => '+7 (000) 222-22-22',
            'email' => 'anton@anton.ru',
            'password' => 'g4jsD#Kz',
            'user_group' => 2,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Sotrudnik',
            'phone' => '+7 (000) 333-33-33',
            'email' => 'sotrudnik@sotrudnik.ru',
            'password' => 'bk3&v0cV',
            'user_group' => 3,
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

        // Категории клиентов
        $clientCategory = [
            ['name' => 'Клиенты'],
            ['name' => 'Дилеры'],
        ];
        foreach($clientCategory as $client) {
            \App\Models\ClientCategory::factory()->create(['name' => $client['name']]);
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

            ['name' => 'Услуги', 'parent_id' => null],

            ['name' => 'Стекло', 'parent_id' => 4],

            ['name' => 'Иконы', 'parent_id' => 10],
            ['name' => 'Полумесяц', 'parent_id' => 10],

            ['name' => 'Текст для памятника', 'parent_id' => null],

        ];
        foreach($categoryList as $category) {
            \App\Models\Category::factory()->create([
                'name' => $category['name'],
                'parent_id' => $category['parent_id'],
            ]);
        }

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

        // Товары
        $productList = [

            // Модели

            // Вертикальные
            ['name' => 1, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 2, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 3, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 4, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 5, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 6, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 7, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 8, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 9, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 10, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 11, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 12, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 13, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 14, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 15, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 16, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 17, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 18, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 19, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 20, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 21, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 22, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 23, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 24, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 25, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 26, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "26a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 27, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 28, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 29, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 30, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 31, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 32, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 33, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 34, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 35, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 36, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 37, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 38, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 39, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 40, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 41, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 42, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 43, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 44, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 45, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "45a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 46, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "46a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 47, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "47a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 48, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "48a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 49, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 50, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "50a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 51, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "51a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 52, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "52a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 53, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "53a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 54, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 55, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "55a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 56, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "56a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 57, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "57a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 58, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "58a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 59, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 60, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "60a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 61, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "61a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 62, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "62a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 63, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => "63a", 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 64, 'price' => 0, 'category_id' => 2, 'sort' => 0],

            // Горизонтальные
            ['name' => 65, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 66, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 67, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 68, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 69, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 70, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 71, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 72, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 73, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 74, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 75, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 76, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 77, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 78, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 79, 'price' => 0, 'category_id' => 3, 'sort' => 0],
            ['name' => 80, 'price' => 0, 'category_id' => 3, 'sort' => 0],

            // Вертикальные
            ['name' => 81, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 82, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 86, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 90, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 91, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 92, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 93, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 94, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 95, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 96, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 98, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 99, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 102, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 103, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 110, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 112, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 113, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 114, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 115, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 116, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 117, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 118, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 119, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 120, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 121, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 122, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 123, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 124, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 125, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 140, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 141, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 142, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 143, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 144, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 145, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 146, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 147, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 148, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 149, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 150, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 151, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 152, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 153, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 154, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 155, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 156, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 157, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 158, 'price' => 0, 'category_id' => 2, 'sort' => 0],
            ['name' => 159, 'price' => 0, 'category_id' => 2, 'sort' => 0],

            // Материал

            // Гранит
            ['name' => 'Габбро', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Габбро Диабаз', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Volga Blue', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Дымовский', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Лезники', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Imperial Red', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Мансуровский', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Масловский', 'price' => 600000, 'category_id' => 5, 'sort' => 0],
            ['name' => 'Гранатовый амфиболит', 'price' => 600000, 'category_id' => 5, 'sort' => 0],

            // Мрамор
            ['name' => 'Полевской', 'price' => 400000, 'category_id' => 6, 'sort' => 0],

            // Портреты

            // Гравировка
            ['name' => 'Бюст', 'price' => 4500, 'category_id' => 8, 'sort' => 0],
            ['name' => 'По пояс', 'price' => 6000, 'category_id' => 8, 'sort' => 0],
            ['name' => 'Во весь рост', 'price' => 8000, 'category_id' => 8, 'sort' => 0],

            // Фотокерамика
            ['name' => 'Прямой 13x18 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 13x18 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 13x18 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 13x18 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 17x22 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 17x22 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 17x22 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 17x22 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 20x30 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 20x30 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 21x27 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Овал 21x27 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 24x30 ч/б', 'price' => 0, 'category_id' => 9, 'sort' => 0],
            ['name' => 'Прямой 24x30 цветная', 'price' => 0, 'category_id' => 9, 'sort' => 0],

            // Дополнительная гравировка

            // Кресты
            ['name' => 'Крест №1', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №2', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №3', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №4', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №5', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №6', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №7', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №8', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №9', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №10', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №11', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №12', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №13', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №14', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №15', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №16', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №17', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №18', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №19', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №20', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №21', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №22', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №23', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №24', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №25', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №26', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №27', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №28', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №29', 'price' => 300, 'category_id' => 11, 'sort' => 0],
            ['name' => 'Крест №30', 'price' => 300, 'category_id' => 11, 'sort' => 0],

            // Цветы
            ['name' => 'Цветы №1', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №2', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №3', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №4', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №5', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №6', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №7', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №8', 'price' => 500, 'category_id' => 12, 'sort' => 0],
            ['name' => 'Цветы №9', 'price' => 500, 'category_id' => 12, 'sort' => 0],

            // Ветви
            ['name' => 'Ветка №1', 'price' => 500, 'category_id' => 13, 'sort' => 0],
            ['name' => 'Ветка №2', 'price' => 500, 'category_id' => 13, 'sort' => 0],
            ['name' => 'Ветка №3', 'price' => 500, 'category_id' => 13, 'sort' => 0],
            ['name' => 'Ветка №4', 'price' => 500, 'category_id' => 13, 'sort' => 0],
            ['name' => 'Ветка №5', 'price' => 500, 'category_id' => 13, 'sort' => 0],
            ['name' => 'Ветка №6', 'price' => 500, 'category_id' => 13, 'sort' => 0],

            // Свечи
            ['name' => 'Свеча №1', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №2', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №3', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №4', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №5', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №6', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №7', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №8', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №9', 'price' => 0, 'category_id' => 14, 'sort' => 0],
            ['name' => 'Свеча №10', 'price' => 0, 'category_id' => 14, 'sort' => 0],

            // Ангелы
            ['name' => 'Ангел №1', 'price' => 0, 'category_id' => 15, 'sort' => 0],
            ['name' => 'Ангел №2', 'price' => 0, 'category_id' => 15, 'sort' => 0],
            ['name' => 'Ангел №3', 'price' => 0, 'category_id' => 15, 'sort' => 0],
            ['name' => 'Ангел №4', 'price' => 0, 'category_id' => 15, 'sort' => 0],
            ['name' => 'Ангел №5', 'price' => 0, 'category_id' => 15, 'sort' => 0],
            ['name' => 'Ангел №6', 'price' => 0, 'category_id' => 15, 'sort' => 0],

            // Птицы
            ['name' => 'Птица №1', 'price' => 0, 'category_id' => 16, 'sort' => 0],
            ['name' => 'Птица №2', 'price' => 0, 'category_id' => 16, 'sort' => 0],
            ['name' => 'Птица №3', 'price' => 0, 'category_id' => 16, 'sort' => 0],
            ['name' => 'Птица №4', 'price' => 0, 'category_id' => 16, 'sort' => 0],
            ['name' => 'Птица №5', 'price' => 0, 'category_id' => 16, 'sort' => 0],
            ['name' => 'Птица №6', 'price' => 0, 'category_id' => 16, 'sort' => 0],

            // Цветник / надгробие
            ['name' => '№1 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№1 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№2 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№2 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№3 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№3 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№4 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№4 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№5 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№5 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№6 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№6 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№7 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№7 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№8 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№8 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№9 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№9 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№10 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№10 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№11 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№11 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№12 - 100x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],
            ['name' => '№12 - 120x5x8', 'price' => 0, 'category_id' => 17, 'sort' => 0],

            // Ограды 16000

            // Полумесяц

            // Вазы 19
            // Литьевые и мрамор 20
            // Гранитные 21
            // Лампады 22


            // Облицовка
            ['name' => 'Тротуарная', 'price' => 6500, 'category_id' => 23, 'sort' => 0],
            ['name' => 'Мрамор + мансуровский гранит', 'price' => 15000, 'category_id' => 23, 'sort' => 0],
            ['name' => 'Сонарский', 'price' => 16000, 'category_id' => 23, 'sort' => 0],
            ['name' => 'Черный + дымовский', 'price' => 20000, 'category_id' => 23, 'sort' => 0],

            // Услуги
            ['name' => 'Доставка до 10км', 'price' => 1000, 'category_id' => 24, 'sort' => 0],
            ['name' => 'Доставка за км', 'price' => 30, 'category_id' => 24, 'sort' => 0],

            // Текст для памятника
            ['name' => 'Фамилия', 'price' => 500, 'category_id' => 28, 'sort' => 0],
            ['name' => 'Имя', 'price' => 500, 'category_id' => 28, 'sort' => 0],
            ['name' => 'Отчество', 'price' => 500, 'category_id' => 28, 'sort' => 0],
            ['name' => 'Дата рождения', 'price' => 500, 'category_id' => 28, 'sort' => 0],
            ['name' => 'Дата смерти', 'price' => 500, 'category_id' => 28, 'sort' => 0],
            ['name' => 'Эпитафия', 'price' => 45, 'category_id' => 28, 'sort' => 0],


        ];
        foreach($productList as $product) {
            \App\Models\Product::factory()->create([
                'name' => $product['name'],
                'price' => $product['price'],
                'category_id' => $product['category_id'],
                'sort' => $product['sort'],
            ]);
        }

        //

    }
}
