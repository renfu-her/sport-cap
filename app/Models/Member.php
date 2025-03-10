<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthday',
        'address',
        'membership_type',
        'membership_start_date',
        'membership_end_date',
        'notes',
        'is_active',
    ];

    protected $hidden = [
        'password',
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

    /**
     * 獲取此會員的所有訂單
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 設置密碼時自動進行雜湊處理
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
}
