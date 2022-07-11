<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @property int $id
 * @property string $email
 * @property string $user_name
 * @property string $fist_name
 * @property string $last_name
 * @property string $password
 * @property int $status
 * @property string $avatar
 * @property timestamp $created_at
 * @property timestamp $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'users_name',
        'password',
        'fist_name',
        'last_name',
        'birthday',
        'reset_password',
        'address',
        'province_id',
        'district_id',
        'commune_id',
        'status','avatar',
        
    ];
    /**
     * relationship user_id with product
     * @return mixed
     */
    public function product()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * relationship user_id with product_category
     * @return mixed
     */
    public function products_category()
    {
        return $this->hasMany(ProductCategory::class, 'user_id');
    }

   
}
