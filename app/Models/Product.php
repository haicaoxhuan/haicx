<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @property int $user_id
 * @property string $sku
 * @property string $name
 * @property int $stock
 * @property string $avatar
 * @property date $expired_at
 * @property timestamp $created_at
 * @property timestamp $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'user_id',
        'sku',
        'name',
        'stock',
        'avatar',
        'expired_at',
        'category_id',
        'flag_delete',
    ];

    public $timestamps = true;

    /**
     * relationship product with user_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * relationship product with category_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products_category()
    {
        return $this->belongsTo(ProductCategory::class,'category_id','id');
    }
}
