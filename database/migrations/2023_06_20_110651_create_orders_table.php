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
            $table->foreignId('status_id')->constrained()->default(1);

            $table->integer('model')->nullable();
            $table->string('model_size')->nullable();
            $table->integer('material')->nullable();
            $table->integer('portrait')->nullable();
            $table->string('portrait_size')->nullable();

            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('fathername')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('death_date')->nullable();
            $table->string('epitafia')->nullable();

            $table->integer('crescent')->default(0);
            $table->integer('cross')->default(0);
            $table->integer('flower')->default(0);
            $table->integer('icon')->default(0);
            $table->integer('branch')->default(0);
            $table->integer('candle')->default(0);
            $table->integer('angel')->default(0);
            $table->integer('bird')->default(0);

            $table->integer('tombstone')->default(0);
            // fence ограда
            // vase ваза

            // facing (product_id) облицовка
            // facing m2

            $table->integer('delivery_km')->nullable();
            $table->text('delivery_addr')->nullable();

            $table->text('comment')->nullable();
            $table->date('deadline_date')->nullable();
            $table->float('total_amount')->default(0);

            // Конструктор. Техданные конструктора
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
