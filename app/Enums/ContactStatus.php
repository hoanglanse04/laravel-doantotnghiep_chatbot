<?php

namespace App\Enums;
enum ContactStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case INTERESTED = 'interested';
    case NOT_INTERESTED = 'not_interested';
    case CONVERTED = 'converted';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Mới',
            self::CONTACTED => 'Đã liên hệ',
            self::INTERESTED => 'Quan tâm',
            self::NOT_INTERESTED => 'Không quan tâm',
            self::CONVERTED => 'Đã chuyển đổi',
            self::ARCHIVED => 'Đã lưu trữ',
        };
    }
}
