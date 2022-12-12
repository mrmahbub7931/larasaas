<?php 
namespace App\Permissions;

use App\Models\Role;
use App\Models\Permission;

trait HasPermissionsTrait{

    /**
     * It takes an array of permissions, and then saves them to the database
     */
    public function givePermissionsTo(... $permissions) : self
    {

        $permissions = $this->getAllPermissions($permissions);
        dd($permissions);
        if($permissions === null) {
          return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    /**
     * > This function removes the permissions from the user
     * 
     * @return self The return value is the current instance of the model.
     */
    public function withdrawPermissionsTo( ... $permissions ) : self
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    /**
     * It removes all permissions from the user and then adds the permissions passed to the function
     * 
     * @return The return value is the result of the givePermissionsTo method.
     */
    public function refreshPermissions( ... $permissions ) {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

   /**
    * If the user has the permission through a role, return true. Otherwise, return the result of the
    * hasPermission() function.
    * 
    * @param permission The permission to check for.
    * 
    * @return The return value is a boolean.
    */
    public function hasPermissionTo($permission) {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }
    
    /**
     * > This function returns a boolean value that indicates whether the user has the given permission
     * through a role
     * 
     * @param permission The name of the permission you want to check for.
     * @return bool
     */
    public function hasPermissionThroughRole($permission) : bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contain($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * > This function returns a boolean value based on whether the user has the specified role
     * @return bool
     */
    public function hasRole(...$roles) : bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug',$role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * The relationship is between many to many Roles and User
     * 
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles');
    }

    /**
     * The relationship is between many to many Permissions and User
     * 
     * @var array
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'user_permissions');
    }


    /**
     * > This function checks if the user has a permission.
     * 
     * @param permission The permission to check for.
     * @return bool
     */
    protected function hasPermission($permission) : bool
    {
        return $this->permissions->whereIn('slug',$permission->slug)->count();
    }

    /**
     * > This function returns an array of all permissions.
     * 
     * @param permissions The permissions that the user has.
     * @return array
     */
    protected function getAllPermissions($permissions) : array
    {
        return Permission::whereIn('slug',$permissions)->get();
    }
}