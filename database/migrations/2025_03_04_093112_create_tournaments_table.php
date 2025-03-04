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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 賽事名稱
            $table->enum('type', ['international', 'domestic']); // 賽事類型：國際賽事、國內賽事
            $table->enum('category', ['img', 'sdjga', 'scpga', 'cga', 'holiday'])->nullable(); // 賽事類別：IMG, SDJGA, SCPGA, 中華高協, 假日年度賽事
            $table->text('description')->nullable(); // 賽事描述
            $table->date('start_date'); // 開始日期
            $table->date('end_date'); // 結束日期
            $table->string('location'); // 舉辦地點
            $table->string('organizer')->nullable(); // 主辦單位
            $table->decimal('entry_fee', 10, 2)->nullable(); // 報名費用
            $table->integer('max_participants')->nullable(); // 最大參與人數
            $table->integer('current_participants')->default(0); // 當前參與人數
            $table->json('schedule')->nullable(); // 賽程安排
            $table->json('requirements')->nullable(); // 參賽要求
            $table->json('prizes')->nullable(); // 獎項設置
            $table->json('images')->nullable(); // 相關圖片
            $table->boolean('is_featured')->default(false); // 是否為精選賽事
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
