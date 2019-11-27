<?php

namespace App\Rbac;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

	public $timestamps = false;

    protected $fillable = [
        'name', 'created'
    ];

    public function permission(){
    	return $this->hasMany('App\Rbac\Permission', 'role_id');
    }
}
