<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
