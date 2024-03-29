<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{   

    // protected $fillable = ['user_id', 'role_id'];
      public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
