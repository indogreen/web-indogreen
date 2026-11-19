<?php

namespace App\Enums;

enum OfficeType: string
{
    case HEAD_OFFICE = 'head_office';
    case REPRESENTATIVE_OFFICE = 'representative_office';

    public function label(): string
    {
        return match ($this) {
            self::HEAD_OFFICE => 'Kantor Utama',
            self::REPRESENTATIVE_OFFICE => 'Kantor Perwakilan',
        };
    }
}
