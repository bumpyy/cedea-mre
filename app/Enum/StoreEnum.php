<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum StoreEnum: string implements HasLabel
{
    case INDOMARET = 'indomaret';
    case ALFAMART = 'alfamart';
    case LAWSON = 'lawson';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDOMARET => 'Indomaret',
            self::ALFAMART => 'Alfamart',
            self::LAWSON => 'Lawson',
        };
    }
}
