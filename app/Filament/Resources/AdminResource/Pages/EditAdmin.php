<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected static ?string $breadcrumb = 'Edit';

    public function getTitle(): string | Htmlable
    {
        return __('Edit Admin');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
