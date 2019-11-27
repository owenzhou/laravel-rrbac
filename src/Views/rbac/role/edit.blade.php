@extends('layouts.blank')

@section('content')

<form class="form-horizontal" method="post" action="/manager/role/saveedit">
	{!! csrf_field() !!}
	
	<input type="hidden" name="id" value="{{$role['id']}}" />

	<div class="form-group">
		<label for="rolename" class="col-sm-2 control-label">角色名：</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="rolename" name="rolename" value="{{$role['name']}}" placeholder="用户名">
		</div>
	</div>

	<div class="form-group">
		<label for="rolename" class="col-sm-2 control-label">创建时间：</label>
		<div class="col-sm-10">
			<div class="form-control">{{$role['created']}}</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">权限：</label>
		<div class="col-sm-10">
			
			<div class="row" style="padding:0 15px;">
	
				<table class="table table-bordered">
					
					<tr>
						<td>权限模块名</td>
					</tr>

					@foreach($permission as $k=>$v)

					<tr>
						<td>
						<span class="bg-success" style="padding: 5px 8px;">{{$k}}</span>
						<br/>
						@foreach($v as $i=>$m)
						<?php $checked = !in_array($m, $route)?:'checked';?>
						<label class="checkbox-inline">
							&nbsp;&nbsp;&nbsp;&nbsp;<input name="actions[]" {{$checked}} type="checkbox" value="{{$m}}" /> {{$i}}
						</label>
						@endforeach()
						</td>
					</tr>

					@endforeach()

				</table>

			</div>

		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">确定</button>
		</div>
	</div>

</form>

@endsection()