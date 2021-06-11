<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Help()
 * @method static static TourFind()
 * @method static static TourCreate()
 * @method static static HotelFind()
 * @method static static HotelCreate()
 */
final class AdminActions extends Enum
{
    const Help = '0';
    const TourFind = '1';
    const TourCreate = '2';
    const HotelFind = '3';
    const HotelCreate = '4';
}
