<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Commune
 *
 * @property int $id
 * @property string $name
 * @property timestamp $created_at
 * @property timestamp $updated_at
 * @property int $district_id
 */

class Commune extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $fillable = [
        'name',
        'district_id'
    ];
    public $timestamps = FALSE;
}
