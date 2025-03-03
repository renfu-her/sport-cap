<?php

namespace App\Filament\Resources\TeachingMethodResource\Pages;

use App\Filament\Resources\TeachingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeachingMethods extends ListRecords
{
    protected static string $resource = TeachingMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
