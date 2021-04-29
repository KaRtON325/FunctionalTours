<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Beach()
 * @method static static Guided()
 * @method static static Active()
 * @method static static Boat()
 * @method static static Nightlife()
 */
final class TourType extends Enum
{
    const Beach = 'beach';
    const Guided = 'guided';
    const Active = 'active';
    const Boat = 'boat';
    const Nightlife = 'nightlife';
}
