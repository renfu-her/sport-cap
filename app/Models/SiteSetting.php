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
}
