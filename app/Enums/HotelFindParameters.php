<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Name()
 * @method static static Stars()
 * @method static static Country()
 * @method static static City()
 */
final class HotelFindParameters extends Enum
{
    const Name = '1';
    const Stars = '2';
    const Country = '3';
    const City = '4';
    const None = '5';
}
