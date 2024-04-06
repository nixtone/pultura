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
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('status_id')->constrained()->default(1);

            // Внешний вид памятника
            $table->integer('model')->default(0);
            $table->string('model_size')->default('');
            $table->integer('material')->default(0);
            $table->integer('portrait')->default(0);

            // Текст для памятника
            $table->string('lastname')->default('');
            $table->string('firstname')->default('');
            $table->string('fathername')->default('');
            $table->string('birth_date')->default('');
            $table->string('death_date')->default('');
            $table->string('epitafia')->default('');

            // Гравировка
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
            $table->float('face_m2')->nullable();
            $table->integer('facing')->nullable();

            // Услуги
            $table->integer('delivery_km')->nullable(); // Адрес доставки
            $table->text('delivery_addr')->nullable(); // Киллометраж доставки
            $table->float('install')->nullable(); // Установка
            $table->float('deinstall')->nullable(); // Демонтаж

            // Остальное
            $table->date('deadline_date')->nullable();
            $table->text('price_list')->null(); // Смета
            $table->text('comment')->nullable();

            //
            $table->softDeletes();
            $table->timestamps();
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
