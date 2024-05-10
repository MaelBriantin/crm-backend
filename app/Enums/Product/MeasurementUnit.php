<?php

namespace App\Enums\Product;

use App\Interfaces\LabelTranslationInterface;
use App\Traits\LabelTranslationTrait;
use Exception;

abstract class MeasurementUnit implements LabelTranslationInterface
{
    use LabelTranslationTrait;

    const MILLIGRAM = 'mg';
    const GRAM = 'g';
    const KILOGRAM = 'kg';
    const MILLILITER = 'ml';
    const CENTILITER = 'cl';
    const LITER = 'l';
    const DECILITER = 'dl';

    public static function getTranslationKey(): string
    {
        return 'products.measurement_units';
    }

    /**
     * @throws Exception
     */
    public static function toLabelValue(): array
    {
        return static::getLabelValues(static::class);
    }

    public static function toArray(): array
    {
        $abstractionClass = new \ReflectionClass(static::class);
        return $abstractionClass->getConstants();
    }

    public static function request(): string
    {
        return implode(',', self::toArray());
    }
}
