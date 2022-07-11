<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\District
 *
 * @property int $id
 * @property string $name
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property int $province_id
 */
class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'name',
        'province_id'
    ];
    public $timestamps = FALSE;

    /**
     * get all the districts of the province.
     *
     * @return HasMany
     */
    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
