<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\rbac\User;
use App\rbac\UserRole;
use Validator;
use Illuminate\Validation\Rule;
use DB;

/**
* 后台用户管理
*/
class AdminUserController extends Controller
{

	protected $rules = [
		'name' => 'required|max:32',
		'email' => [
			'required',
			'max:168',
		],
	];

	protected $messages = [
		'name.required'=>'请输入用户名',
		'email.required'=>'请输入邮箱',
		'email.unique'=>'邮箱已存在',
	];

    /**
     * 用户列表
     */
    public function index(Request $request)
    {
        $page = $request->query('page');
		$pageSize = $request->query('pageSize');
		$searchWord = $request->query('searchWord');
		$db = User::with(['roles'])->orderBy('id', 'desc');
		$total = User::count();
		if( !empty($searchWord) ){
			$db->where('name', 'like', '%'.$searchWord.'%');
			$total = $db->count();
		}
		
		$result = $db->offset(($page-1)*$pageSize)->limit($pageSize)->get();
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
     * 创建用户
     */
    public function store(Request $request)
    {
        $post = $request->all();
		array_push($this->rules['email'], Rule::unique('users'));
		$validator = Validator::make($post, $this->rules, $this->messages);
        if( $validator->fails() ){
			$errmsg = '';
			foreach($validator->errors()->all() as $v){
				$errmsg .= $v."\r\n";
			}
			return ['errcode'=>1, 'errmsg'=>$errmsg];
		}
		$post['password'] = bcrypt($post['password']);
		$result = User::create($post);
		if( !empty($result->id) ){
			$userId = $result->id;
    		foreach($post['roles'] as $role){
    			UserRole::insert(['user_id'=>$userId, 'role_id'=>$role]);
    		}
		}
		return ['errcode'=>0, 'errmsg'=>''];
    }

    /**
     * 显示用户
     */
    public function show($id)
    {
        $result = User::with(['roles'])->find($id);

		return ['result'=>$result, 'total'=>1];
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
     * 保存用户
     */
    public function update(Request $request, $id)
    {
        $post = $request->all();
		array_push($this->rules['email'], Rule::unique('users')->ignore($id));
		$validator = Validator::make($post, $this->rules, $this->messages);
        if( $validator->fails() ){
			$errmsg = '';
			foreach($validator->errors()->all() as $v){
				$errmsg .= $v."\r\n";
			}
			return ['errcode'=>1, 'errmsg'=>$errmsg];
		}
		$website = User::find($id);
		$website->update($post);
		$roleIds = json_decode(UserRole::where('user_id', $id)->pluck('role_id'), true);
		$dbDiff = array_diff($roleIds, $post['roles']);
    	$uDiff = array_diff($post['roles'], $roleIds);
		
		foreach($dbDiff as $i){
			UserRole::where([['user_id','=',$id], ['role_id','=',$i]])->first()->delete();
		}
		foreach($uDiff as $j){
			UserRole::insert(['user_id'=>$id, 'role_id'=>$j]);
		}
		return ['errcode'=>0, 'errmsg'=>''];
    }

    /**
     * 删除用户
     */
    public function destroy($id)
    {
        User::find($id)->delete();
		return ['errcode'=>0, 'errmsg'=>''];
    }
}
