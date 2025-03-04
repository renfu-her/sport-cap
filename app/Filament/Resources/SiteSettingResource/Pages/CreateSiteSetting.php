<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;

    public function mount(): void
    {
        // 檢查是否已經存在設定記錄
        $setting = SiteSetting::first();

        if ($setting) {
            // 如果已經存在，則重定向到編輯頁面
            redirect()->to($this->getResource()::getUrl('edit', ['record' => $setting]));
        }

        parent::mount();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
