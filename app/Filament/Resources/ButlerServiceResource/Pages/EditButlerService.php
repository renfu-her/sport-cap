<?php

namespace App\Filament\Resources\ButlerServiceResource\Pages;

use App\Filament\Resources\ButlerServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditButlerService extends EditRecord
{
    protected static string $resource = ButlerServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
