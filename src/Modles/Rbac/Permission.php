<?php

namespace App\rbac;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

	public $timestamps = false;

    protected $fillable = [
    	'role_id', 'action'
    ];
}
