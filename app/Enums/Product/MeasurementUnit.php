<?php

namespace App\Enums\Product;

enum MeasurementUnit
{
    const NONE = null;
    const MILLIGRAM = 'mg';
    const GRAM = 'g';
    const KILOGRAM = 'kg';
    const MILLILITER = 'ml';
    const CENTILITER = 'cl';
    const LITER = 'l';
    const DECILITER = 'dl';

    public static function toLabelValue(): array
    {
        return [
            // self::NONE => trans('measurement_units.'.self::NONE),
            trans('products.measurement_units.'.self::MILLIGRAM) => self::MILLIGRAM,
            trans('products.measurement_units.'.self::GRAM) => self::GRAM,
            trans('products.measurement_units.'.self::KILOGRAM) => self::KILOGRAM,
            trans('products.measurement_units.'.self::MILLILITER) => self::MILLILITER,
            trans('products.measurement_units.'.self::CENTILITER) => self::CENTILITER,
            trans('products.measurement_units.'.self::LITER) => self::LITER,
            trans('products.measurement_units.'.self::DECILITER) => self::DECILITER
        ];
    }

    public static function toArray(): array
    {
        return [
            self::MILLIGRAM,
            self::GRAM,
            self::KILOGRAM,
            self::MILLILITER,
            self::CENTILITER,
            self::LITER,
            self::DECILITER
        ];
    }

    public static function request(): string
    {
        return implode(',', self::toArray());
    }
}
