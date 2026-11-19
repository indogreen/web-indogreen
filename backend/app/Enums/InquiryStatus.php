<?php

namespace App\Enums;

enum InquiryStatus: string
{
    case PENDING = 'pending';
    case CONTACTED = 'contacted';
    case QUOTED = 'quoted';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu Ditinjau',
            self::CONTACTED => 'Sudah Dihubungi',
            self::QUOTED => 'Penawaran Terkirim',
            self::CLOSED => 'Selesai',
            self::ARCHIVED => 'Diarsipkan',
        };
    }
}
