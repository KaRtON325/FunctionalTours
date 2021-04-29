<?php

namespace App\Models;

use Database\Factories\TourFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Tour
 * @package App\Models
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $name
 * @property string $country
 * @property string $type
 * @property string $meals
 * @property string $start_date
 * @property string $end_date
 */
class Tour extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tours';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'hotel'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id', 'name', 'country', 'type', 'meals', 'start_date', 'end_date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the hotel in the tour.
     */
    public function hotel(): HasOne
    {
        return $this->hasOne(Hotel::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TourFactory::new();
    }
}
