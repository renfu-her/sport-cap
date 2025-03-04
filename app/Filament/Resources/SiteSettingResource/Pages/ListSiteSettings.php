<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 移除創建按鈕，因為我們只需要一個設定記錄
        ];
    }

    protected function getTableQuery(): Builder
    {
        // 確保至少有一個設定記錄
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

        return parent::getTableQuery();
    }

    public function mount(): void
    {
        parent::mount();

        // 直接重定向到編輯頁面
        $setting = SiteSetting::first();

        if ($setting) {
            redirect()->to($this->getResource()::getUrl('edit', ['record' => $setting]));
        }
    }
}
