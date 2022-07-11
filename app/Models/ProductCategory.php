<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class ProductCategory
 * @property int $parent_id
 * @property int $user_id
 * @property string $name
 * @property timestamp $created_at
 * @property timestamp $updated_at
 */
class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'products_category';
    protected $fillable = [
        'users_id',
        'name',
        'parent_id',
    ];
    public $timestamps = true;

    /**
     *relationship category_id with  user_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}

