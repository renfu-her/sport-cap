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
        Schema::create('butler_services', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 服務名稱
            $table->enum('type', ['shipping', 'ecommerce', 'itinerary']); // 服務類型：球袋國際運送、高爾夫電商、套裝行程規劃
            $table->text('description')->nullable(); // 服務描述
            $table->decimal('price', 10, 2)->nullable(); // 價格
            $table->json('details')->nullable(); // 服務詳情
            $table->json('features')->nullable(); // 服務特點
            $table->json('process')->nullable(); // 服務流程
            $table->json('faqs')->nullable(); // 常見問題
            $table->json('images')->nullable(); // 相關圖片
            $table->boolean('is_featured')->default(false); // 是否為精選服務
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butler_services');
    }
};
