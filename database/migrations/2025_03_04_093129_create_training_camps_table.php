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
        Schema::create('training_camps', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 訓練團名稱
            $table->text('description')->nullable(); // 訓練團描述
            $table->date('start_date'); // 開始日期
            $table->date('end_date'); // 結束日期
            $table->string('country'); // 國家
            $table->string('city'); // 城市
            $table->string('venue'); // 訓練場地
            $table->string('coach')->nullable(); // 教練
            $table->decimal('fee', 10, 2); // 費用
            $table->integer('max_participants')->nullable(); // 最大參與人數
            $table->integer('current_participants')->default(0); // 當前參與人數
            $table->json('schedule')->nullable(); // 訓練安排
            $table->json('accommodation')->nullable(); // 住宿安排
            $table->json('transportation')->nullable(); // 交通安排
            $table->json('meals')->nullable(); // 餐飲安排
            $table->json('equipment')->nullable(); // 裝備要求
            $table->json('images')->nullable(); // 相關圖片
            $table->boolean('is_featured')->default(false); // 是否為精選訓練團
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_camps');
    }
};
