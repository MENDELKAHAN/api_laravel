<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = [
        'name', 'slug',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'roles_permissions',  'role_id', 'permission_id');
    }

 	public function users()
    {
        return $this->belongsToMany('App\User', 'users_roles',  'user_id', 'role_id');
    }
}
