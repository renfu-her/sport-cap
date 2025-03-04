<?php

namespace App\Filament\Resources\TrainingCampResource\Pages;

use App\Filament\Resources\TrainingCampResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingCamps extends ListRecords
{
    protected static string $resource = TrainingCampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
