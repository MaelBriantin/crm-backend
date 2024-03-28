<?php

namespace App\Enums\Product;

enum MeasurementUnit
{
    const MILLIGRAM = 'mg';
    const GRAM = 'g';
    const KILOGRAM = 'kg';
    const MILLILITER = 'ml';
    const CENTILITER = 'cl';
    const LITER = 'l';

    public static function toArray(): array
    {
        return [
            self::MILLIGRAM,
            self::GRAM,
            self::KILOGRAM,
            self::MILLILITER,
            self::CENTILITER,
            self::LITER,
        ];
    }
}
