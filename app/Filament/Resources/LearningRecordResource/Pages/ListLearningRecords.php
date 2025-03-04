<?php

namespace App\Filament\Resources\LearningRecordResource\Pages;

use App\Filament\Resources\LearningRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Actions\ExportAction;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\IconPosition;

class ListLearningRecords extends ListRecords
{
    protected static string $resource = LearningRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('新增學習記錄')
                ->icon('heroicon-o-plus')
                ->iconPosition(IconPosition::Before),

            Actions\Action::make('export')
                ->label('匯出學習記錄')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('filament.backend.resources.learning-records.index'))
                ->color('success')
                ->size(ActionSize::Small)
                ->visible(false), // 暫時隱藏，等待匯出功能實現
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // 可以添加統計小部件，如學習記錄總數、完成率等
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            // 可以添加圖表小部件，如學習記錄趨勢等
        ];
    }
}
