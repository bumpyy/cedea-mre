<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum StoreEnum: string implements HasLabel
{
    case INDOMARET = 'indomaret';
    case ALFAMART = 'alfamart';
    case ALFAMIDI = 'alfamidi';
    case FAMIMA = 'famima';
    case LAWSON = 'lawson';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDOMARET => 'Indomaret',
            self::ALFAMART => 'Alfamart',
            self::FAMIMA => 'Family Mart',
            self::ALFAMIDI => 'Alfamidi',
            self::LAWSON => 'Lawson',
            self::OTHER => 'Other',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INDOMARET => '#FFD700',
            self::ALFAMART => '#DA251D',
            self::ALFAMIDI => '#4a0300',
            self::FAMIMA => '#009b3f',
            self::LAWSON => '#006CB7',
            self::OTHER => '#808080',
        };
    }
}
