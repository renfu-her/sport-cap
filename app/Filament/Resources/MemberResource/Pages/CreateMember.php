<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Member;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string|Htmlable
    {
        return '新增會員';
    }

    protected function beforeCreate(): void
    {
        // 檢查電子郵件是否已被註冊
        $email = $this->data['email'] ?? null;

        if ($email && Member::where('email', $email)->exists()) {
            Notification::make()
                ->title('電子郵件已被註冊')
                ->body('此電子郵件已經被其他會員使用，請使用其他電子郵件。')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        // 創建成功後顯示通知
        Notification::make()
            ->title('會員創建成功')
            ->body('新會員已成功添加到系統中。')
            ->success()
            ->send();
    }
}
