<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 先檢查外鍵是否存在
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
            AND TABLE_NAME = 'teaching_methods'
            AND CONSTRAINT_NAME = 'teaching_methods_teacher_id_foreign'
        ");

        // 只有在外鍵存在時才嘗試刪除
        if (!empty($foreignKeys)) {
            Schema::table('teaching_methods', function (Blueprint $table) {
                $table->dropForeign('teaching_methods_teacher_id_foreign');
            });
        }

        // 接著添加新的外鍵或執行其他操作
        Schema::table('teaching_methods', function (Blueprint $table) {
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
