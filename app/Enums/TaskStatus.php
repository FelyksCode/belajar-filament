<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TaskStatus: string implements HasLabel, HasColor
{
    case TODO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case IN_REVIEW = 'In Review';
    case COMPLETED = 'Completed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TODO => 'To Do',
            self::IN_PROGRESS => 'In Progress',
            self::IN_REVIEW => 'In Review',
            self::COMPLETED => 'Completed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::TODO => 'blue',
            self::IN_PROGRESS => 'yellow',
            self::IN_REVIEW => 'orange',
            self::COMPLETED => 'green',
        };
    }

    public static function getColumns(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $status) => [$status->value => $status->getLabel()])
            ->toArray();
    }

    public static function getColumnColors(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $status) => [$status->value => $status->getColor()])
            ->toArray();
    }
}
