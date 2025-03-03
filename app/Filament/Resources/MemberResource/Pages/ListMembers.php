<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('新增會員'),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return '會員管理';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return '管理所有會員資料';
    }
}
