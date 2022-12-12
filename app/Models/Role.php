<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The many to many relationship declare
     *
     * @var array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }

    /**
     * The many to many relationship declare
     *
     * @var array
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'user_roles');
    }
}
