<?php

namespace App\Traits;

use App\Interfaces\LabelTranslationInterface;

trait LabelTranslationTrait
{
    public static function getLabelValues(string $class): array
    {
        if(!class_implements($class, LabelTranslationInterface::class)) {
            throw new \Exception('Class must implement LabelTranslationInterface');
        }

        $translationKey = $class::getTranslationKey();

        return collect($class::toArray())->mapWithKeys(function ($constant) use ($translationKey) {
            return [trans($translationKey . '.'. $constant) => $constant];
        })->toArray();
    }
}
