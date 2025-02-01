<?php

namespace App\Filament\Resources\ProductMeasurmentResource\Pages;

use App\Filament\Resources\ProductMeasurmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListProductMeasurments extends ListRecords
{
    protected static string $resource = ProductMeasurmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('Measurements Data');
    }
}
