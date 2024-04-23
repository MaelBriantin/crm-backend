<?php

namespace App\Enums\Product;

enum VatRate
{
    const FIVE_FIVE = 5.5;
    const TEN = 10;
    const TWENTY = 20;

    public static function getTransKeys(): array
    {
        return [
            self::FIVE_FIVE => 'products.vat_rates.5_5',
            self::TEN => 'products.vat_rates.10',
            self::TWENTY => 'products.vat_rates.20',
        ];
    }

    public static function toLabelValue()
    {
        return [
            trans(self::getTransKeys()[self::FIVE_FIVE]) => self::FIVE_FIVE,
            trans(self::getTransKeys()[self::TEN]) => self::TEN,
            trans(self::getTransKeys()[self::TWENTY]) => self::TWENTY,
        ];
    }

    public static function toArray(): array
    {
        return [
            self::TEN,
            self::FIVE_FIVE,
            self::TWENTY,
        ];
    }

    public static function request(): string
    {
        return implode(',', self::toArray());
    }
}
