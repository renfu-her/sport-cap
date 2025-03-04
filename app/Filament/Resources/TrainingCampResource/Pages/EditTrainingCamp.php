<?php

namespace App\Filament\Resources\TrainingCampResource\Pages;

use App\Filament\Resources\TrainingCampResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingCamp extends EditRecord
{
    protected static string $resource = TrainingCampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
