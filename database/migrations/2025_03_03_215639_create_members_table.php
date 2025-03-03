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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');                           // 姓名
            $table->string('email')->unique()->nullable();    // 電子郵件（唯一，可為空）
            $table->string('phone')->nullable();              // 電話
            $table->date('birthday')->nullable();             // 生日
            $table->text('address')->nullable();              // 地址
            $table->enum('membership_type', ['basic', 'premium', 'vip'])->default('basic'); // 會員類型
            $table->date('membership_start_date')->nullable(); // 會員開始日期
            $table->date('membership_end_date')->nullable();   // 會員結束日期
            $table->text('notes')->nullable();                // 備註
            $table->boolean('is_active')->default(true);      // 是否啟用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
