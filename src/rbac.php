<?php


Route::group([ 'prefix' => 'rbac', 'middleware' => ['VerifyPermission'] ], function () {

	Route::get('/permission/error', function(){
		return view('error.permission');
	});

    Route::get('/', function(){
        return '欢迎您';
    });

	//后台用户管理
    Route::get('/admin/index', 'rbac\AdminController@index');
    Route::any('/admin/edit/{id}', 'AdminController@edit');
    Route::any('/admin/add', 'AdminController@edit');

    //角色管理首页
    Route::get('/role/index', 'RoleController@index');
    Route::get('/role/edit/{id}', 'RoleController@edit');
    Route::post('/role/saveedit', 'RoleController@saveEdit');

    //权限管理首页
    Route::get('/permission/index', 'PermissionController@index');
    
});