<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Resources\ParameterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewParameter extends ViewRecord
{
    protected static string $resource = ParameterResource::class;

    // Adding header actions
    protected function getHeaderActions(): array
    {
        return [
            // Add the EditAction or any other custom action you want to show in the header
            Actions\EditAction::make(),
        ];
    }
}
