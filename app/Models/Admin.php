<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Admin
 * @property string $email
 * @property string $user_name
 * @property string $fist_name
 * @property string $last_name
 * @property string $password
 * @property int $status
 * @property boolean $flag_delete
 * @property timestamp $created_at
 * @property timestamp $updated_at
 */
class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'email',
        'user_name',
        'birthday',
        'fist_name',
        'last_name',
        'password',
        'status',
        'flag_delete',
    ];

    public $timestamps = true;
}
