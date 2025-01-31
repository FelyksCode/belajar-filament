<?php

namespace App\Filament\Resources\OperatorResource\Pages;

use App\Filament\Resources\OperatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListOperators extends ListRecords
{
    protected static string $resource = OperatorResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Operators');
    }


    protected static ?string $breadcrumb = 'List';



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
