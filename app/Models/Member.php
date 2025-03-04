<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthday',
        'address',
        'membership_type',
        'membership_start_date',
        'membership_end_date',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'birthday' => 'date',
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * 獲取此會員的所有學習記錄
     */
    public function learningRecords(): HasMany
    {
        return $this->hasMany(LearningRecord::class);
    }
}
