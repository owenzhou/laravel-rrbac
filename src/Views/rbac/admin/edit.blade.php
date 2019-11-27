@extends('layouts.blank')

@section('content')

<form class="form-horizontal" method="post">
	{!! csrf_field() !!}
	<input type="hidden" name="id" value="{{empty($user)?'':$user['id']}}" />

	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">用户名：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="username" name="username" value="{{empty($user)?'':$user['name']}}" placeholder="用户名">
		</div>
	</div>

	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">创建时间：</label>
		<div class="col-sm-10">
			<div class="form-control">{{empty($user)?'':$user['created']}}</div>
		</div>
	</div>

	<div class="form-group">
		<label for="username" class="col-sm-2 control-label">角色：</label>
		<div class="col-sm-10">
			@foreach($role as $n)
				<?php $checked = !in_array($n['id'], $userRoleIds) ?: 'checked';?>
				<label class="checkbox-inline">
				  <input type="checkbox" name="roles[]" {{$checked}} value="{{$n['id']}}"> {{$n['name']}}
				</label>
			@endforeach()
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">确定</button>
		</div>
	</div>

</form>

@endsection()