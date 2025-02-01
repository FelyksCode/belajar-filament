<?php

namespace App\Filament\Resources\ProductMeasurmentResource\Pages;

use App\Filament\Resources\ProductMeasurmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductMeasurment extends EditRecord
{
    protected static string $resource = ProductMeasurmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
