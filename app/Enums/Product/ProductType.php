<?php

namespace App\Enums\Product;

enum ProductType
{
    const DEFAULT = 'default';
    const CLOTHES = 'clothes';

    public static function toLabelValue(): array
    {
        return [
            trans('products.product_types.default') => self::DEFAULT,
            trans('products.product_types.clothes') => self::CLOTHES,
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

