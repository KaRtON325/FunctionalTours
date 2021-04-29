<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Hotel
 * @package App\Models
 *
 * @property string $name
 * @property int $starts
 * @property string $country
 * @property string $city
 * @property string $address
 */
class Hotel extends Model
{
    use HasFactory;

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
     * Get the hotel in the tour.
     */
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
