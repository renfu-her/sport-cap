<?php

namespace App\Filament\Resources\LearningRecordResource\Pages;

use App\Filament\Resources\LearningRecordResource;
use App\Models\TeachingMethod;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateLearningRecord extends CreateRecord
{
    protected static string $resource = LearningRecordResource::class;

    // 創建記錄後重定向到列表頁面
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // 創建記錄後的處理
    protected function afterCreate(): void
    {
        // 獲取剛創建的學習記錄
        $record = $this->record;

        // 如果是團體班，增加當前參與人數
        $teachingMethod = TeachingMethod::find($record->teaching_method_id);
        if ($teachingMethod && $teachingMethod->type === 'group') {
            $teachingMethod->increment('current_participants');
        }

        // 發送通知
        Notification::make()
            ->title('學習記錄已創建')
            ->success()
            ->body("已成功創建 {$record->member->name} 的學習記錄")
            ->send();
    }

    // 自定義表單標題
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('創建學習記錄'),
            $this->getCancelFormAction()
                ->label('取消'),
        ];
    }

    // 自定義創建按鈕
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('創建學習記錄')
            ->icon('heroicon-o-check')
            ->color('success');
    }

    // 自定義取消按鈕
    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('取消')
            ->icon('heroicon-o-x-mark')
            ->color('gray');
    }
}
