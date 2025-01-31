<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Admins');
    }


    protected static ?string $breadcrumb = 'List';


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
