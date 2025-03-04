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
        Schema::create('learning_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade'); // 會員ID
            $table->foreignId('teaching_method_id')->constrained()->onDelete('cascade'); // 教學方式ID
            $table->date('attendance_date'); // 出席日期
            $table->enum('status', ['attended', 'absent', 'late'])->default('attended'); // 出席狀態
            $table->integer('duration_minutes')->nullable(); // 學習時長（分鐘）
            $table->text('progress_notes')->nullable(); // 學習進度備註
            $table->text('teacher_feedback')->nullable(); // 教師反饋
            $table->text('member_feedback')->nullable(); // 會員反饋
            $table->boolean('is_completed')->default(false); // 是否完成
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_records');
    }
};
