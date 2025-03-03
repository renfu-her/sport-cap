<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'members_only',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'members_only' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(About::class, 'teacher_id');
    }
}
