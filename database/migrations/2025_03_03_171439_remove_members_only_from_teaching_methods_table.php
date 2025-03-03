<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * 移除 teaching_methods 表中的 members_only 欄位
     */
    public function up(): void
    {
        Schema::table('teaching_methods', function (Blueprint $table) {
            $table->dropColumn('members_only');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * 恢復 teaching_methods 表中的 members_only 欄位
     */
    public function down(): void
    {
        Schema::table('teaching_methods', function (Blueprint $table) {
            $table->boolean('members_only')->default(false)->after('location');
        });
    }
};
