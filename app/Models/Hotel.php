<?php

namespace App\Models;

use Database\Factories\HotelFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Hotel
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $stars
 * @property string $country
 * @property string $city
 * @property string $address
 */
class Hotel extends Model
{
    use HasFactory;

    const MIN_NAME_LENGTH = 3;
    const MIN_STARS = 1;
    const MAX_STARS = 5;
    const MIN_COUNTRY_LENGTH = 3;
    const MIN_CITY_LENGTH = 2;
    const MIN_ADDRESS_LENGTH = 5;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'stars', 'country', 'city', 'address',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Get the tour in the hotel.
     */
    public function tour(): HasOne
    {
        return $this->hasOne(Tour::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return HotelFactory::new();
    }
}
