<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Breakfast()
 * @method static static Lunch()
 * @method static static Dinner()
 * @method static static AllInclusive()
 */
final class TourMeals extends Enum
{
    const Breakfast = 'breakfast';
    const Lunch = 'lunch';
    const Dinner = 'dinner';
    const AllInclusive = 'all inclusive';
}
