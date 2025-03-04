<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'category',
        'description',
        'start_date',
        'end_date',
        'location',
        'organizer',
        'entry_fee',
        'max_participants',
        'current_participants',
        'schedule',
        'requirements',
        'prizes',
        'images',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'entry_fee' => 'decimal:2',
        'schedule' => 'array',
        'requirements' => 'array',
        'prizes' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * 獲取賽事類型的顯示名稱
     */
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'international' => '國際賽事',
            'domestic' => '國內賽事',
            default => $this->type,
        };
    }

    /**
     * 獲取賽事類別的顯示名稱
     */
    public function getCategoryNameAttribute(): string
    {
        return match ($this->category) {
            'img' => 'IMG',
            'sdjga' => 'SDJGA',
            'scpga' => 'SCPGA',
            'cga' => '中華高協',
            'holiday' => '假日年度賽事',
            default => $this->category,
        };
    }

    /**
     * 檢查賽事是否已滿
     */
    public function isFull(): bool
    {
        return $this->max_participants !== null && $this->current_participants >= $this->max_participants;
    }

    /**
     * 檢查賽事是否正在進行中
     */
    public function isOngoing(): bool
    {
        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * 檢查賽事是否已結束
     */
    public function isEnded(): bool
    {
        return now()->isAfter($this->end_date);
    }

    /**
     * 檢查賽事是否尚未開始
     */
    public function isUpcoming(): bool
    {
        return now()->isBefore($this->start_date);
    }
}
