<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 將網站設定注入到所有視圖中
        View::composer('*', function ($view) {
            $setting = SiteSetting::first();

            if (!$setting) {
                $setting = SiteSetting::create([
                    'site_name' => '全球高爾夫管家',
                    'site_title' => '全球高爾夫管家 - 專業高爾夫服務',
                    'site_description' => '全球高爾夫管家提供專業的賽事團、國外移地訓練團和管家服務，為高爾夫愛好者提供全方位的支持。',
                    'site_keywords' => '高爾夫,賽事,訓練,管家服務,球袋運送,電商,行程規劃',
                    'footer_copyright' => '© ' . date('Y') . ' 全球高爾夫管家. 版權所有.',
                ]);
            }

            $view->with('siteSetting', $setting);
        });
    }
}
