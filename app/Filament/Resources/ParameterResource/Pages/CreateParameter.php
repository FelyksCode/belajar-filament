<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Resources\ParameterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateParameter extends CreateRecord
{
    protected static string $resource = ParameterResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Create Product Parameters');
    }
}
