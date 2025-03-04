<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'country',
        'city',
        'venue',
        'coach',
        'fee',
        'max_participants',
        'current_participants',
        'schedule',
        'accommodation',
        'transportation',
        'meals',
        'equipment',
        'images',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'fee' => 'decimal:2',
        'schedule' => 'array',
        'accommodation' => 'array',
        'transportation' => 'array',
        'meals' => 'array',
        'equipment' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * 獲取訓練團地點的完整名稱
     */
    public function getLocationAttribute(): string
    {
        return "{$this->country} {$this->city} {$this->venue}";
    }

    /**
     * 檢查訓練團是否已滿
     */
    public function isFull(): bool
    {
        return $this->max_participants !== null && $this->current_participants >= $this->max_participants;
    }

    /**
     * 檢查訓練團是否正在進行中
     */
    public function isOngoing(): bool
    {
        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * 檢查訓練團是否已結束
     */
    public function isEnded(): bool
    {
        return now()->isAfter($this->end_date);
    }

    /**
     * 檢查訓練團是否尚未開始
     */
    public function isUpcoming(): bool
    {
        return now()->isBefore($this->start_date);
    }

    /**
     * 獲取訓練團的持續天數
     */
    public function getDurationDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
}
