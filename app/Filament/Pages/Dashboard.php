<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Redirect;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        // 重定向到 abouts 頁面
        redirect()->to('/backend/abouts')->send();
    }

    public function getTitle(): string|Htmlable
    {
        return '儀表板';
    }
}
