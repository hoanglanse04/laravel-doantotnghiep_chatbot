<?php

namespace App\Enums;

enum ContentType: string
{
    case PROJECT = 'project';
    case POST = 'post';
    case PRODUCT = 'product';
    case FAQ = 'faq';

    public function label(): string
    {
        return match ($this) {
            self::PROJECT => 'Dự án',
            self::POST => 'Bài viết',
            self::PRODUCT => 'Sản phẩm',
            self::FAQ => 'Hỏi đáp',
        };
    }

    public static function fromString(?string $value): ?self
    {
        return match ($value) {
            'project' => self::PROJECT,
            'post' => self::POST,
            'product' => self::PRODUCT,
            'faq' => self::FAQ,
            default => null,
        };
    }
}
