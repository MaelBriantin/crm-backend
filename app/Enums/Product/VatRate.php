<?php

namespace App\Enums\Product;

enum VatRate
{
    const FIVE_FIVE = 5.5;
    const TEN = 10;
    const TWENTY = 20;

    public static function toArray(): array
    {
        return [
            self::TEN,
            self::FIVE_FIVE,
            self::TWENTY,
        ];
    }
}
