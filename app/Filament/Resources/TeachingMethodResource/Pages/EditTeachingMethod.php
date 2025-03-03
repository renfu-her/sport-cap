<?php

namespace App\Filament\Resources\TeachingMethodResource\Pages;

use App\Filament\Resources\TeachingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeachingMethod extends EditRecord
{
    protected static string $resource = TeachingMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
