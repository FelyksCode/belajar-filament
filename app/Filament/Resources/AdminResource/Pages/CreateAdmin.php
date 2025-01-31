<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;


    public function getTitle(): string | Htmlable
    {
        return __('Create Admin');
    }
}
