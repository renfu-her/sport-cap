<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'teaching_method_id',
        'order_number',
        'price',
        'tax',
        'sub_total',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'tax' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * 獲取此訂單的會員
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 獲取此訂單的教學方式
     */
    public function teachingMethod(): BelongsTo
    {
        return $this->belongsTo(TeachingMethod::class);
    }

    /**
     * 生成唯一的訂單編號
     */
    public static function generateOrderNumber(): string
    {
        $today = date('Ymd');
        
        // 查詢今天的最後一個訂單編號
        $lastOrder = self::where('order_number', 'like', "ORD-{$today}-%")
            ->orderBy('order_number', 'desc')
            ->first();
        
        if ($lastOrder) {
            // 從最後一個訂單編號中提取序號並加1
            $lastNumber = (int) substr($lastOrder->order_number, -3);
            $newNumber = $lastNumber + 1;
        } else {
            // 如果今天還沒有訂單，則從1開始
            $newNumber = 1;
        }
        
        // 格式化為三位數，不足前面補0
        $formattedNumber = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        
        return "ORD-{$today}-{$formattedNumber}";
    }

    /**
     * 計算訂單總額
     */
    public function calculateTotal(): float
    {
        return $this->sub_total + $this->tax;
    }
} 