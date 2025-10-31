<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum MeasurementUnits : string
{
    case Grams100 = "100g";
    case Milliliters100 = "100ml";
}
