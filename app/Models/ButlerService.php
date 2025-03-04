<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButlerService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'price',
        'details',
        'features',
        'process',
        'faqs',
        'images',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'details' => 'array',
        'features' => 'array',
        'process' => 'array',
        'faqs' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * 獲取服務類型的顯示名稱
     */
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'shipping' => '球袋國際運送',
            'ecommerce' => '高爾夫電商',
            'itinerary' => '套裝行程規劃',
            default => $this->type,
        };
    }

    /**
     * 檢查服務是否為球袋國際運送
     */
    public function isShipping(): bool
    {
        return $this->type === 'shipping';
    }

    /**
     * 檢查服務是否為高爾夫電商
     */
    public function isEcommerce(): bool
    {
        return $this->type === 'ecommerce';
    }

    /**
     * 檢查服務是否為套裝行程規劃
     */
    public function isItinerary(): bool
    {
        return $this->type === 'itinerary';
    }
}
