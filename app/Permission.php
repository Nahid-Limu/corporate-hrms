<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
   public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

     public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
