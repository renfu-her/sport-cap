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
            $table->integer('max_participants')->nullable()->after('location'); // 最大參與人數
            $table->integer('current_participants')->default(0)->after('max_participants'); // 當前參與人數
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teaching_methods', function (Blueprint $table) {
            $table->dropColumn(['max_participants', 'current_participants']);
        });
    }
};
