<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum MeasurementUnits : string implements TranslatableInterface
{
    case Grams100 = "100g";
    case Milliliters100 = "100ml";

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::Grams100  => $translator->trans('100 g', locale: $locale),
            self::Milliliters100  => $translator->trans('100 ml', locale: $locale),
        };
    }
}
