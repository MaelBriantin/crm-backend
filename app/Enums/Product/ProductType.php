<?php

namespace App\Enums\Product;

abstract class ProductType
{
    const DEFAULT = 'default';
    const CLOTHES = 'clothes';

    public static function toLabelValue(): array
    {
        return [
            trans('products.product_types.'.self::DEFAULT) => self::DEFAULT,
            trans('products.product_types.'.self::CLOTHES) => self::CLOTHES,
        ];
    }

    public static function toArray(): array
    {
        return [
            self::DEFAULT,
            self::CLOTHES,
        ];
    }

    public static function request(): string
    {
        return implode(',', self::toArray());
    }
}

