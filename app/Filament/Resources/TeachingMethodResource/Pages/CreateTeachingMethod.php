<?php

namespace App\Filament\Resources\TeachingMethodResource\Pages;

use App\Filament\Resources\TeachingMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTeachingMethod extends CreateRecord
{
    protected static string $resource = TeachingMethodResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
