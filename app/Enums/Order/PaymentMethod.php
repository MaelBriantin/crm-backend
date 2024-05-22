<?php

namespace App\Enums\Order;

use App\Interfaces\LabelTranslationInterface;
use App\Traits\LabelTranslationTrait;
use Exception;

abstract class PaymentMethod implements LabelTranslationInterface
{
    use LabelTranslationTrait;

    const CREDIT_CARD = 'credit_card';
    const CHECK = 'check';
    const CASH = 'cash';
    const BANK_TRANSFER = 'bank_transfer';

    public static function getTranslationKey(): string
    {
        return 'orders.means_of_payment';
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
