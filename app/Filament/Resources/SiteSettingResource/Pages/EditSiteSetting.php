<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 移除刪除按鈕，因為我們只需要一個設定記錄
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 如果沒有設定記錄，則創建一個默認的
        if (empty($data)) {
            $setting = SiteSetting::first();

            if (!$setting) {
                $setting = SiteSetting::create([
                    'site_name' => '全球高爾夫管家',
                    'site_title' => '全球高爾夫管家 - 專業高爾夫服務',
                    'site_description' => '全球高爾夫管家提供專業的賽事團、國外移地訓練團和管家服務，為高爾夫愛好者提供全方位的支持。',
                    'site_keywords' => '高爾夫,賽事,訓練,管家服務,球袋運送,電商,行程規劃',
                    'footer_copyright' => '© ' . date('Y') . ' 全球高爾夫管家. 版權所有.',
                ]);

                $data = $setting->toArray();
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('網站設定已更新')
            ->body('網站設定已成功更新。');
    }
}
