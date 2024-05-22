<?php

namespace App\Interfaces;

interface LabelTranslationInterface
{
    public static function toArray(): array;
    public static function getTranslationKey(): string;
}
