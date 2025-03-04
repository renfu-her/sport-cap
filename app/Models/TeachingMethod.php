<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeachingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'type',
        'title',
        'description',
        'images',
        'start_date',
        'end_date',
        'price',
        'location',
        'is_active',
        'max_participants', // 最大參與人數（團體班適用）
        'current_participants', // 當前參與人數（團體班適用）
    ];

    protected $casts = [
        'images' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
    ];

    /**
     * 獲取此教學方式的教師
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(About::class, 'teacher_id');
    }

    /**
     * 獲取此教學方式的所有學習記錄
     */
    public function learningRecords(): HasMany
    {
        return $this->hasMany(LearningRecord::class);
    }

    /**
     * 判斷此教學方式是否為個人課程
     */
    public function isIndividual(): bool
    {
        return $this->type === 'individual';
    }

    /**
     * 判斷此教學方式是否為團體班
     */
    public function isGroup(): bool
    {
        return $this->type === 'group';
    }
}
