<?php

namespace App\Filament\Resources\ProductMeasurmentResource\Pages;

use App\Filament\Resources\ProductMeasurmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateProductMeasurment extends CreateRecord
{
    protected static string $resource = ProductMeasurmentResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string | Htmlable
    {
        return __('Measure a Product');
    }
}
