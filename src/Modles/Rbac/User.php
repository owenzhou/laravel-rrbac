<?php

namespace App\Rbac;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    //public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password'
    ];

	protected $hidden = ['api_token', 'created_at', 'updated_at', 'password', 'remember_token'];

    public function roles(){
    	return $this->belongsToMany('App\Rbac\Role', 'user_role', 'user_id', 'role_id');
    }
}
