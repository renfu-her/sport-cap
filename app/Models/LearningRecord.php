<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'teaching_method_id',
        'attendance_date',
        'status',
        'duration_minutes',
        'progress_notes',
        'teacher_feedback',
        'member_feedback',
        'is_completed',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'duration_minutes' => 'integer',
        'is_completed' => 'boolean',
    ];

    /**
     * 獲取此學習記錄關聯的會員
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 獲取此學習記錄關聯的教學方式
     */
    public function teachingMethod(): BelongsTo
    {
        return $this->belongsTo(TeachingMethod::class);
    }
}
