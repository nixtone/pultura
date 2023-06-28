<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

    }
}
