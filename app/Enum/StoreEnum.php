<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum StoreEnum: string implements HasLabel
{
    case INDOMARET = 'indomaret';
    case ALFAMART = 'alfamart';
    case ALFAMIDI = 'alfamidi';
    case FAMILYMART = 'famima';
    case LAWSON = 'lawson';
    case OTHER = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::INDOMARET => 'Indomaret',
            self::ALFAMART => 'Alfamart',
            self::FAMILYMART => 'FamilyMart',
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
            self::FAMILYMART => '#009b3f',
            self::LAWSON => '#006CB7',
            self::OTHER => '#808080',
        };
    }
}
