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
        Schema::table('teaching_methods', function (Blueprint $table) {
            // 先刪除原有的外鍵約束
            $table->dropForeign(['teacher_id']);

            // 重新添加指向abouts表的外鍵約束
            $table->foreign('teacher_id')
                ->references('id')
                ->on('abouts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_methods', function (Blueprint $table) {
            // 刪除指向abouts表的外鍵約束
            $table->dropForeign(['teacher_id']);

            // 恢復指向users表的外鍵約束
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
