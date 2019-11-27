<?php

namespace App\rbac;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

	public $timestamps = false;

    protected $fillable = [
        'name', 'created'
    ];

    public function permission(){
    	return $this->hasMany('App\rbac\Permission', 'role_id');
    }
}
