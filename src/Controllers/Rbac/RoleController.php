<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rbac\Role;
use App\Rbac\Permission;
use Validator;
use Illuminate\Validation\Rule;

/**
* 角色管理
*/
class RoleController extends Controller
{

	protected $rules = [
		'name' => 'required|max:32',
	];

	protected $messages = [
		'name.required' => '请输入角色名',	
	];

    /**
     * 角色列表
     */
    public function index(Request $request)
    {
		$page = $request->query('page');
		$pageSize = $request->query('pageSize');
		$searchWord = $request->query('searchWord');
        $db = Role::orderBy('id', 'desc');
		$total = Role::count();
		if( !empty($searchWord) ){
			$db->where('name', 'like', '%'.$searchWord.'%');
			$total = $db->count();
		}
		if( !empty($page) && !empty($pageSize) ){
			$db->offset(($page-1)*$pageSize)->limit($pageSize);
		}
		$result = $db->get();
		return ['result'=>$result, 'total'=>$total];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * 创建角色
     */
    public function store(Request $request)
    {
        $post = $request->all();
		$validator = Validator::make($post, $this->rules, $this->messages);
        if( $validator->fails() ){
			$errmsg = '';
			foreach($validator->errors()->all() as $v){
				$errmsg .= $v."\r\n";
			}
			return ['errcode'=>1, 'errmsg'=>$errmsg];
		}
		$post['created'] = date('Y-m-d H:i:s');
		$result = Role::create($post);
		foreach($post['permissions'] as $permission){
			Permission::insert(['role_id'=>$result->id, 'action'=>$permission]);
		}
		return ['errcode'=>0, 'errmsg'=>''];
    }

    /**
     * 显示角色
     */
    public function show($id)
    {
        $result = Role::with(['permission'])->find($id);
		return ['result'=>$result, 'total'=>count($result)];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 角色修改
     */
    public function update(Request $request, $id)
    {
        $post = $request->all();
		$validator = Validator::make($post, $this->rules, $this->messages);
        if( $validator->fails() ){
			$errmsg = '';
			foreach($validator->errors()->all() as $v){
				$errmsg .= $v."\r\n";
			}
			return ['errcode'=>1, 'errmsg'=>$errmsg];
		}
		$website = Role::find($id);
		$website->update($post);
		$actions = json_decode(Permission::where('role_id', $id)->pluck('action'), true);
		$dbDiff = array_diff($actions, $post['permissions']);
    	$uDiff = array_diff($post['permissions'], $actions);
		
		foreach($dbDiff as $i){
			Permission::where([['role_id','=',$id],['action','=',$i]])->first()->delete();
		}
		foreach($uDiff as $j){
			Permission::insert(['role_id'=>$id, 'action'=>$j]);
		}
		return ['errcode'=>0, 'errmsg'=>''];
    }

    /**
     * 角色删除
     */
    public function destroy($id)
    {
        Role::find()->delete();
		return ['errcode'=>0, 'errmsg'=>''];
    }
}
