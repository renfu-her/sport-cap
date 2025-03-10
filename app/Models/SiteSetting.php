<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_title',
        'site_description',
        'site_keywords',
        'site_logo',
        'site_logo_dark',
        'site_favicon',
        'site_og_image',
        'site_twitter_image',
        'contact_email',
        'contact_phone',
        'contact_address',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'line_url',
        'footer_text',
        'footer_copyright',
        'google_analytics_code',
        'facebook_pixel_code',
        'custom_css',
        'custom_js',
        'tax_type',           // 稅金類型：'included'（內含）或 'excluded'（另計）
        'tax_rate',           // 稅率（百分比）
        'max_price_no_tax',   // 最高價格（免稅）
    ];

    protected $casts = [
        'tax_rate' => 'float',
        'max_price_no_tax' => 'float',
    ];

    /**
     * 獲取網站設定
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::first();

        if (!$setting) {
            return $default;
        }

        return $setting->$key ?? $default;
    }

    /**
     * 更新網站設定
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function updateSetting(string $key, $value): bool
    {
        $setting = self::first();

        if (!$setting) {
            $setting = new self();
        }

        $setting->$key = $value;

        return $setting->save();
    }

    /**
     * 批量更新網站設定
     *
     * @param array $data
     * @return bool
     */
    public static function updateSettings(array $data): bool
    {
        $setting = self::first();

        if (!$setting) {
            $setting = new self();
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $setting->fillable)) {
                $setting->$key = $value;
            }
        }

        return $setting->save();
    }

    /**
     * 計算稅金
     *
     * @param float $price 價格
     * @return array 包含 price, tax, sub_total, total 的陣列
     */
    public static function calculateTax(float $price): array
    {
        $setting = self::first();
        
        if (!$setting) {
            // 默認設定：稅率 5%，另計稅金
            $taxRate = 0.05;
            $taxType = 'excluded';
            $maxPriceNoTax = 0;
        } else {
            $taxRate = $setting->tax_rate / 100; // 轉換為小數
            $taxType = $setting->tax_type ?? 'excluded';
            $maxPriceNoTax = $setting->max_price_no_tax ?? 0;
        }

        // 如果價格超過最高免稅價格，則不收稅
        if ($maxPriceNoTax > 0 && $price >= $maxPriceNoTax) {
            $tax = 0;
            $subTotal = $price;
            $total = $price;
            return [
                'price' => $price,
                'tax' => $tax,
                'sub_total' => $subTotal,
                'total' => $total,
            ];
        }

        // 根據稅金類型計算
        if ($taxType === 'included') {
            // 內含稅金
            $subTotal = $price / (1 + $taxRate);
            $tax = $price - $subTotal;
            $total = $price;
        } else {
            // 另計稅金
            $subTotal = $price;
            $tax = $price * $taxRate;
            $total = $subTotal + $tax;
        }

        return [
            'price' => $price,
            'tax' => round($tax, 2),
            'sub_total' => round($subTotal, 2),
            'total' => round($total, 2),
        ];
    }
}
