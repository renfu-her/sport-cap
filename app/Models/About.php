<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'content',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function teachingMethods(): HasMany
    {
        return $this->hasMany(TeachingMethod::class, 'teacher_id');
    }

    public function scopeTeachers($query)
    {
        return $query->where('section', 'team_teacher')->where('is_active', true);
    }
}
