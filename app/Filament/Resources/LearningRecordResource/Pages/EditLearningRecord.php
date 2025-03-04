<?php

namespace App\Filament\Resources\LearningRecordResource\Pages;

use App\Filament\Resources\LearningRecordResource;
use App\Models\TeachingMethod;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class EditLearningRecord extends EditRecord
{
    protected static string $resource = LearningRecordResource::class;

    // 保存原始教學方式ID，用於檢測變更
    protected $originalTeachingMethodId;

    // 頁面掛載時保存原始教學方式ID
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->originalTeachingMethodId = $data['teaching_method_id'] ?? null;
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('刪除學習記錄')
                ->icon('heroicon-o-trash')
                ->modalHeading('刪除學習記錄')
                ->modalDescription('確定要刪除此學習記錄嗎？此操作無法撤銷。')
                ->modalSubmitActionLabel('確認刪除')
                ->modalCancelActionLabel('取消')
                ->successNotificationTitle('學習記錄已刪除'),

            Actions\Action::make('viewMember')
                ->label('查看會員')
                ->icon('heroicon-o-user')
                ->url(fn() => route('filament.backend.resources.members.edit', ['record' => $this->record->member_id]))
                ->openUrlInNewTab(),
        ];
    }

    // 保存記錄後重定向到列表頁面
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // 保存記錄前的處理
    protected function beforeSave(): void
    {
        // 檢查教學方式是否變更
        $newTeachingMethodId = $this->data['teaching_method_id'] ?? null;

        if ($this->originalTeachingMethodId && $newTeachingMethodId && $this->originalTeachingMethodId != $newTeachingMethodId) {
            // 獲取原始和新的教學方式
            $oldTeachingMethod = TeachingMethod::find($this->originalTeachingMethodId);
            $newTeachingMethod = TeachingMethod::find($newTeachingMethodId);

            // 如果原始教學方式是團體班，減少參與人數
            if ($oldTeachingMethod && $oldTeachingMethod->type === 'group') {
                $oldTeachingMethod->decrement('current_participants');
            }

            // 如果新教學方式是團體班，檢查是否已滿
            if ($newTeachingMethod && $newTeachingMethod->type === 'group') {
                if ($newTeachingMethod->max_participants !== null && $newTeachingMethod->current_participants >= $newTeachingMethod->max_participants) {
                    // 如果已滿，顯示錯誤通知
                    Notification::make()
                        ->title('團體班已滿')
                        ->danger()
                        ->body("無法更改為此教學方式，因為團體班 {$newTeachingMethod->title} 已滿")
                        ->send();

                    // 阻止保存
                    $this->halt();
                }
            }
        }
    }

    // 保存記錄後的處理
    protected function afterSave(): void
    {
        // 檢查教學方式是否變更
        $newTeachingMethodId = $this->data['teaching_method_id'] ?? null;

        if ($this->originalTeachingMethodId && $newTeachingMethodId && $this->originalTeachingMethodId != $newTeachingMethodId) {
            // 獲取新的教學方式
            $newTeachingMethod = TeachingMethod::find($newTeachingMethodId);

            // 如果新教學方式是團體班，增加參與人數
            if ($newTeachingMethod && $newTeachingMethod->type === 'group') {
                $newTeachingMethod->increment('current_participants');
            }
        }

        // 發送通知
        Notification::make()
            ->title('學習記錄已更新')
            ->success()
            ->body("已成功更新 {$this->record->member->name} 的學習記錄")
            ->send();
    }

    // 自定義表單標題
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('保存更改'),
            $this->getCancelFormAction()
                ->label('取消'),
        ];
    }

    // 自定義保存按鈕
    protected function getSaveFormAction(): Actions\Action
    {
        return parent::getSaveFormAction()
            ->label('保存更改')
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
