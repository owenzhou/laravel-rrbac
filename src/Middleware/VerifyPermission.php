<?php

namespace App\Http\Middleware;

use Closure;
use App\rbac\Permission;
use App\rbac\UserRole;
use Auth;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $except = [
        'api/login',
        'api/signout',
        'home',
    ];

    public function handle($request, Closure $next)
    {
        $requestUri = trim($request->getRequestUri(), '/');
        if( in_array($requestUri, $this->except) )
            return $next($request);

        //admin拥有所有权限
        $user = Auth::guard('api')->user();
        if( $user->name == 'admin' )
            return $next($request);

        $actionName = $request->route()->getActionName();
        //通过uid获取role_id,再通过role_id获取权限
        $roles = json_decode(UserRole::where(['user_id' => $user->id])->pluck('role_id'), true);
        $actions = json_decode(Permission::whereIn('role_id', $roles)->pluck('action'), true);
        if( !in_array($actionName, $actions) )
            return response()->json(['code'=>403, 'message'=>'403 Forbidden']);;

        return $next($request);
    }
}
