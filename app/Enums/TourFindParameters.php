<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Country()
 * @method static static Type()
 * @method static static Meals()
 * @method static static Hotel()
 */
final class TourFindParameters extends Enum
{
    const Country = '1';
    const Type = '2';
    const Meals = '3';
    const Hotel = '4';
    const None = '5';
}
