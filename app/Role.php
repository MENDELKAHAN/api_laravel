<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	  protected $fillable = [
        'name', 'slug',
    ];



	public function permissions()
    {
       
         return $this->belongsToMany('App\Permission', 'roles_permissions',  'role_id', 'permission_id');
    }

  public function users()
    {
        return $this->belongsToMany('App\User', 'users_roles',  'user_id', 'role_id');
    }
}
