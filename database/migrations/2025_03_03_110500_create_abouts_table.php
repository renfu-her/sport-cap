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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('section');  // 區塊：團隊宗旨、團隊顧問等
            $table->string('title');    // 標題
            $table->text('content');    // 內容
            $table->string('image')->nullable();  // 圖片路徑
            $table->boolean('is_active')->default(true);  // 啟用狀態
            $table->integer('sort_order')->default(0);  // 排序
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
