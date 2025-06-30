<?php

namespace App\Filament\Resources\StepResource\Pages;

use App\Filament\Resources\StepResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStep extends CreateRecord
{
    protected static string $resource = StepResource::class;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
