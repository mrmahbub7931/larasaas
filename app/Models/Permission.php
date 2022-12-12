<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    /**
     * The relationship between many to many 
     *
     * @var array
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'user_permissions');
    }

    /**
     * The relationship between many to many 
     *
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_permissions');
    }
}
