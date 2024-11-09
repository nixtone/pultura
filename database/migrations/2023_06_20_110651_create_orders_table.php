<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            // Детали заказа
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Клиент
            $table->foreignId('user_id')->constrained(); // Кто создал заказ
            $table->foreignId('status_id')->constrained()->default(1); // Статус выполнения заказа
            $table->text('comment')->nullable(); // Комментарий к заказу

            // Услуги
            $table->mediumText('services')->nullable(); // Адрес доставки, Км доставки, Установка, Демонтаж

            $table->mediumText('price_list')->nullable(); // Данные от конструктора
            $table->mediumText('estimate')->nullable(); // Данные от конструктора
            $table->float('price')->nullable();
            $table->float('total_correct')->nullable();

            // Даты
            $table->date('deadline_date')->nullable(); // Исполнить заказ до
            $table->softDeletes();
            $table->timestamps();



            // Внешний вид памятника
            /*
            // Модель памятника (mm - monument)
            $table->foreignId('mm_model')
                ->default(0)
                ->constrained()
                ->on('products')
                ->references('id');

            // Размер памятника
            $table->foreignId('mm_model_size')
                ->default(0)
                ->constrained()
                ->on('products')
                ->references('id');

            // Материал памятника
            $table->foreignId('mm_material')
                ->default(0)
                ->constrained()
                ->on('products')
                ->references('id');
            */

            // Содержимое памятника
            // $table->mediumText('mm_details')->nullable(); // текста, гравировки, дополнения, облицовка
            /*
            // Текст для памятника
            $table->string('lastname')->default('');
            $table->string('firstname')->default('');
            $table->string('fathername')->default('');
            $table->string('birth_date')->default('');
            $table->string('death_date')->default('');
            $table->string('epitafia')->default('');

            // Гравировка
            $table->integer('portrait')->default(0);
            $table->integer('crescent')->default(0); // Полумесяц
            $table->integer('cross')->default(0); // Крест
            $table->integer('flower')->default(0); // Цветы
            $table->integer('icon')->default(0); // Иконы
            $table->integer('branch')->default(0); // Ветвь
            $table->integer('candle')->default(0); // Свеча
            $table->integer('angel')->default(0); // Ангел
            $table->integer('bird')->default(0); // Птицы

            // Дополненения
            $table->integer('tombstone')->default(0); // Цветник / надгробие
            $table->integer('fence')->nullable(); // Ограда
            $table->integer('vase')->nullable(); // Ваза

            // Облицовка
            $table->float('face_m2')->comment('Площадь')->nullable();
            $table->integer('facing')->comment('Материал')->nullable();


            // Услуги
            $table->integer('delivery_km')->nullable(); // Адрес доставки
            $table->text('delivery_addr')->nullable(); // Киллометраж доставки
            $table->float('install')->nullable(); // Установка
            $table->float('deinstall')->nullable(); // Демонтаж

            //$table->text('price_list')->null(); // Смета
            */


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
